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
		
		if($extends){
			$this->addHeaders($extends->getHeaders());
		}
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
		
		$this->setHeaders($headers);
		
		return $this;
		
		
		$args = [];
		$md = $this->getMarkdown();
		
		preg_match_all("/-{3}(.*?)-{3}(.*)/s", $md, $total);
    	
    	$tbl = explode(PHP_EOL, $total[1][0]);
	    
	    $this->setBody($total[2][0]);
	    
	    $content = '';
	    
	    $stop = -1;
	    
	    foreach($tbl as $row){
	    	$row = trim($row);
	    	$pos = strpos($row, ':');
	    	
	    	if($pos !==false) {
		    	$key = trim(substr($row,0,$pos));
		    	$value = trim(substr($row,$pos+1));	
		    	
		    	if(substr($value,0, 9) == 'Markdown('){
		    		$page = new Page(MARKDOWN_PATH.substr($value,9, strlen($value)-10).'.md');
		    		$value = $page->getHtml();
		    	}
		    	if(!$value)	$value = [];
		    	if($value === 'true') $value = true;
	    		if($value === 'false') $value = false;
	    		
	    		$args[$key] = $value;
	    	}
	    	elseif(substr($row,0,1)=='-' && isset($key)) {
	    		$args[$key][] = trim(substr($row,1));
	    		continue;
	    	}
	    }
	    
	    $this->setHeaders($args);
	    
	    return $this;
	
	}
	
}