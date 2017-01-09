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
   		\Sensibilis\Model\Service\Site::requireConfiguration($args);
   		
   		$args = array_merge($args, \Sensibilis\Model\Service\Markdown::parseToArgs(file_get_contents(MARKDOWN_PATH.$request->getParam('path', HOME_PATH).'.md')));
   		
   		if(!$args['markdown']){
   			$args['markdown'] = '---'.PHP_EOL.'draft: true'.PHP_EOL.'path: '.$request->getParam('path').PHP_EOL.'site: '.$args['site'].PHP_EOL.PHP_EOL.'---';
   		}
   		
   		$args['sites'] = \Sensibilis\Model\Service\Site::listConfiguration();
   		$this->app->view->render($response, 'editor.html', $args);
   		return $response;
   }
   
   public function save(Request $request, Response $response, $args){
   		$content = $request->getParam('content');
		$args = \Sensibilis\Model\Service\Markdown::parseToArgs($content);
		
		\Sensibilis\Model\Service\Site::requireConfiguration($args);
		
		// recursive directory creation
		$path = $args['path'];
		
		if($path){
			mkdir(MARKDOWN_PATH.$path, 0777, true);
		}
		
		// create md content not deployed
		header('Location: '.$_SERVER['HTTP_REFERER']);
		file_put_contents(MARKDOWN_PATH.$path.'.md', $content);
		return $response;
   }
}