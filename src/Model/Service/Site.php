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
	            $results[] = $path;
	        }
	    }

	    return $results;
	}
	public static function listPath(){
		return self::getDirFiles(MARKDOWN_PATH);
	}
	public static function listConfiguration(){
		return self::getDirFiles(CONF_DIR);
	}
}