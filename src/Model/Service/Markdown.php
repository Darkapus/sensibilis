<?php
namespace Sensibilis\Model\Service;

class Markdown{
	public static function toHtml($md){
		return \Michelf\MarkdownExtra::defaultTransform($md);
	}
	
	public static function parseToArgs($md){
		$args = [];
    	
	    $args['markdown'] = $md;
	    
	    $tbl = explode(PHP_EOL, $md);
	    
	    $content = '';
	    
	    $stop = -1;
	    
	    while(true){
	    	$row = array_shift($tbl);
	    	
	    	if(is_null($row)) break;
	    	
	    	if(trim($row) =='---') {
	    		$stop++;
	    		continue;
	    	}
	    	
	    	if($stop) {
	    		$content .= PHP_EOL . $row;
	    		continue;
	    	}
	    	
	    	$row = trim($row);
	    	if(substr($row,0,1)=='-' && isset($key)) {
	    		$args[$key][] = trim(substr($row,1));
	    		continue;
	    	}
	    	
	    	$explode = explode(':', $row);
	    	list($key, $value) = $explode;
	    	
	    	$key = trim($key);
	    	
	    	$value = trim($value);
	    	
	    	if($value == 'true') $value = true;
	    	if($value == 'false') $value = true;
	    	
	    	if(!$value){
	    		$args[$key] = [];
	    	}
	    	else{
	    		$args[$key] = $value;
	    	}
	    }
	    
	    $args['content'] = self::toHtml($content);
	    
	    return $args;
	}
}