<?php
namespace Sensibilis\Model\Document;

use Symfony\Component\Yaml\Yaml;

class Page {
	protected $path;
	protected $headers;
	protected $markdown;
	protected $body;
	
	public function __construct($mdpath, Page $extends = null) {
		$this->path = $mdpath;
		$this->setMarkdown(file_get_contents($mdpath));
		
		// parse se header
		// extends
		$this->parse();
		
		if(!is_null($extends)){
			$this->setParent($extends);
			$this->addHeaders($extends->getHeaders());
		}
	}
	
	protected $parent;
	public function setParent($parent){
		$parent->addChild($this);
		$this->parent = $parent;
		return $this;
	}
	public function getParent(){
		return $this->parent;
	}
	protected $children;
	public function addChild($child){
		$this->children[$child->getHeader('updated')] = $child;
		krsort($this->children);
		return $this;
	}
	public function getChildren(){
		return $this->children;
	}
	
	public function getPath(){
		return $this->path;
	}
	
	public function setMarkdown($markdown){
		$this->markdown = $markdown;
		return $this;
	}
	public function getMarkdown(){
		return $this->markdown;
	}
	
	protected function addHeaders($args){
		$this->headers = array_merge($args, $this->headers);
		return $this;
	}
	protected function setHeaders($args){
		$this->headers = $args;
		return $this;
	}
	
	public function getHeader($name, $default = null){
		if(array_key_exists($name, $this->headers)) {
			return $this->headers[$name];
		}
		
		return $default;
	}
	
	public function getHeaders(){
		return $this->headers;
	}
	public function setBody($body){
		$this->body = $body;
		return $this;
	}
	public function getBody(){
		return $this->body;
	}
	public function getHtml(){
		return \Michelf\MarkdownExtra::defaultTransform($this->getBody());
	}
	
	public function deleteMarkdown(){
		unlink($this->getPath());
		return $this;
	}
	public function deleteHtml(){
		if(file_exists(HTML_PATH.$this->getHeader('path').'/index.html'))
		unlink(HTML_PATH.$this->getHeader('path').'/index.html');
		return $this;
	}
	
	protected function parse(){
		preg_match_all("/-{3}(.*?)-{3}(.*)/s", $this->getMarkdown(), $total);
		
		$this->setBody($total[2][0]);
		
		$headers = Yaml::parse($total[1][0]);
		
		foreach($headers as $key=>$header) {
			if(is_array($header) && array_key_exists('markdown', $header)) {
				$value = $header['markdown'];
				$markdownfile = MARKDOWN_PATH.$value.'.md';
				$page = new Page($markdownfile);
				$headers[$key] = $page->getHtml();
			}
		}
		
		// markdown update time
		$headers['updated'] = date("Y-m-d H:i:s", filemtime($this->getPath()));
		
		$start_date = new \DateTime($headers['updated']);
		$since_start = $start_date->diff(new \DateTime());
		
		$since = '';
		
		if($since_start->y){
			$since = $since_start->y.' years';
		}
		elseif($since_start->m){
			$since = $since_start->m.' months';
		}
		elseif($since_start->d){
			$since = $since_start->d.' days';
		}
		elseif($since_start->h){
			$since = $since_start->h.' hours';
		}
		elseif($since_start->i){
			$since = $since_start->i.' minutes';
		}
		elseif($since_start->s){
			$since = $since_start->s.' seconds';
		}
		$headers['since'] = $since;
		
		$this->setHeaders($headers);
		
		return $this;
	}
	
}