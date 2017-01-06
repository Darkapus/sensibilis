<?php
namespace Sensibilis\Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Editor 
{
   protected $app;

   // constructor receives container instance
   public function __construct($app) {
       $this->app = $app;
   }
   
   public function form(Request $request, Response $response, $args){
   		$this->app->view->render($response, 'editor.html', \Sensibilis\Model\Service\Markdown::parseToArgs(file_get_contents(MARKDOWN_PATH.$request->getParam('path', HOME_PATH).'.md')));
   		return $response;
   }
   
   public function save(Request $request, Response $response, $args){
	   	$content = $request->getParam('content');
		$args = \Sensibilis\Model\Service\Markdown::parseToArgs($content);
		
		// recursive directory creation
		$path = $args['path'];
		
		if($path){
			mkdir(MARKDOWN_PATH.$path, 0777, true);
		}
		
		// create md content not deployed
		header('Location: '.ADMIN_PATH.'edit?path='.$path);
		file_put_contents(MARKDOWN_PATH.$path.'.md', $content);
		return $response;
   }
}