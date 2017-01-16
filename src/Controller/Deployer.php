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
   		// config required to deploy
   		// seams site var is not interesting
   		\Sensibilis\Model\Service\Site::requireConfiguration($args);
   		
   		// twig template prepare
   		$settings = $this->app->get('settings')['renderer'];
   		$loader = new \Twig_Loader_Filesystem($settings['template_path']);
		$twig = new \Twig_Environment($loader, array(
		    /*'cache' => $settings['template_cache'],*/
		));
		
   		$pages = \Sensibilis\Model\Service\Site::listAllPage();
   		
   		foreach($pages as $page){
   			$args		= $page->getHeaders();
   			var_dump($args);
   			
   			// do not deploy html if the content is a draft
   			if(array_key_exists('draft', $args) && $args['draft'] == true){
   				$page->deleteHtml();
   				continue;
   			} 
   			if(array_key_exists('delete', $args) && $args['delete'] == true) {
   				$page->deleteHtml();
   				$page->deleteMarkdown();
   				continue;
   			}
   			$template 	= $args['site'];
   			$type		= 'index';
   			
   			/*if(array_key_exists('template', $args)){
   				$template = $args['template'];
   			}*/
   			if(array_key_exists('type', $args)){
   				$type = $args['type'];
   			}
   			
   			
   			$template = $twig->load('template/'.$template.'/'.$type.'.html');
   			
   			if(!array_key_exists('site', $args)) {
   				$args['site'] = DEFAULT_CONF;
   			}
   			
   			
   			mkdir(HTML_PATH.$args['path'], 0777, true);
   			
   			//var_dump($args);
   			
   			$args['markdown'] = $page->getBody();
   			$args['content'] = $page->getHtml();
   			
   			$html = $template->render($args);
   			
   			file_put_contents(HTML_PATH.$args['path'].'/index.html', $html);
   		}
   		exit;
   }
}