<?php
namespace Sensibilis\Model\Service;

class Markdown{
	public static function toHtml($markdown){
		return \Michelf\MarkdownExtra::defaultTransform($markdown);
	}
	
	public static function getDirFiles($dir, &$results = array()){
	    $files = scandir($dir);
	
	    foreach($files as $value){
	        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
	        if(!is_dir($path)) {
	            $results[] = $path;
	        } else if($value != "." && $value != "..") {
	            self::getDirFiles($path, $results);
	            $results[] = $path;
	        }
	    }

		

	    return $results;
	}
	
	public static function listAll(){
		return self::getDirFiles(MARKDOWN_PATH);
	}
	
	public static function parseToArgs($markdown){
		$args = [];
    	
	    $args['markdown'] = $markdown;
	    
	    $tbl = explode(PHP_EOL, $markdown);
	    
	    $content = '';
	    
	    $stop = -1;
	    
	    while(true){
	    	$row = array_shift($tbl);
	    	
	    	if(is_null($row)) break;
	    	
	    	if(trim($row) =='---') {
	    		$stop++;
	    		
	    		if($stop<=1)
	    		continue;
	    	}
	    	
	    	if($stop) {
	    		$content .= PHP_EOL . $row;
	    		continue;
	    	}
	    	
	    	$row = trim($row);
	    	
	    	$pos = strpos($row, ':');
	    	
	    	if($pos !==false) {
		    	$key = trim(substr($row,0,$pos));
		    	$value = trim(substr($row,$pos+1));	
		    
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
	    
	    $args['body'] = $content;
	    $args['content'] = self::toHtml($content);
	    
	    return $args;
	}
}
