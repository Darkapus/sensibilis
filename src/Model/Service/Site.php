<?php

namespace Sensibilis\Model\Service;

class Site{
	public static function requireConfiguration(&$args = []){
		if(!array_key_exists('site', $args)){
			$args['site'] = DEFAULT_CONF;
   			require CONF_DIR . DEFAULT_CONF . '.conf.php';
   		}
   		else{
   			require CONF_DIR . $args['site'] . '.conf.php';
   		}
	}
	public static function getDirFiles($dir, &$results = array()){
	    $files = scandir($dir);
	
	    foreach($files as $key => $value){
	        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
	        if(!is_dir($path)) {
	        	$path = str_replace(CONF_DIR		, '', $path);
	        	$path = str_replace(MARKDOWN_PATH	, '', $path);
	        	
	        	$path = substr($path, 0, strpos($path, '.'));
	            $results[] = $path;
	        } else if($value != "." && $value != "..") {
	            self::getDirFiles($path, $results);
	            
	        }
	    }
	    
	    // order by string length
		usort($results, function($a,$b){
		    //return strlen($b)-strlen($a);
		    // needed for extend
		    return strlen($a) <=> strlen($b); // php 7
		});

	    return $results;
	}
	public static function listAllPage() {
		$paths = self::listMarkdown();
		$pages = [];
		foreach($paths as $path) {
			// manage extends here: 
			// for example, "/documentation/markdown" extends of "/documentation" extends of "/"
			// if /documentation does not exists, /documentation/markdown does not extend of "/". The chain is break.
			$extends = null;
			$lastPage = substr($path, 0, strrpos($path, "/"));
			if(array_key_exists($lastPage, $pages)) {
				$extends = $pages[$lastPage];
			}
			
			$pages[$path] = new \Sensibilis\Model\Document\Page(MARKDOWN_PATH.$path.'.md', $extends);
		}
		return $pages;
	}
	
	public static function listMarkdown(){
		return self::getDirFiles(MARKDOWN_PATH);
	}
	public static function listConfiguration(){
		return self::getDirFiles(CONF_DIR);
	}
}