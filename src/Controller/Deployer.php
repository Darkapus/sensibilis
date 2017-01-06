<?php
namespace Sensibilis\Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Deployer 
{
   protected $app;

   // constructor receives container instance
   public function __construct($app) {
       $this->app = $app;
   }
   
   public function html(Request $request, Response $response, $args){
   		$mds = \Sensibilis\Model\Service\Markdown::listAll();
   		
   		$settings = $this->app->get('settings')['renderer'];
   		
   		$loader = new \Twig_Loader_Filesystem($settings['template_path']);
		$twig = new \Twig_Environment($loader, array(
		    'cache' => $settings['template_cache'],
		));

		$template = $twig->load('index.html');
   		
   		foreach($mds as $mdpath){
   			if(strpos($mdpath, '.md') ===false) continue; // only markdown files
   			
   			$args = \Sensibilis\Model\Service\Markdown::parseToArgs(file_get_contents($mdpath));
   			
   			mkdir(HTML_PATH.$args['path'], 0777, true);
   			
   			$html = $template->render($args);
   			
   			file_put_contents(HTML_PATH.$args['path'].'/index.html', $html);
   		}
   		exit;
   }
}