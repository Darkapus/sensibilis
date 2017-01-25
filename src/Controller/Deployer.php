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
<<<<<<< HEAD
   		$services 			= $request->getAttribute('services');
=======
>>>>>>> 15ef4230c94a224ef3835f06bb044fdfb86945c8
   		$serviceSite 		= $services->get('Site');
   		$serviceMarkdown 	= $services->get('Markdown');
   	
   		// config required to deploy
   		// seams site var is not interesting
   		$serviceSite::requireConfiguration($args);
   		
   		// twig template prepare
   		$settings = $this->app->get('settings')['renderer'];
   		$loader = new \Twig_Loader_Filesystem($settings['template_path']);
		$twig = new \Twig_Environment($loader, array(
		    /*'cache' => $settings['template_cache'],*/
		));
		$twig->addExtension(new \Twig_Extension_StringLoader());
		
   		$pages = $serviceSite::listAllPage();
   		
   		foreach($pages as $page){
   			$args		= $page->getHeaders();
   			
   			
   			// do not deploy html if the content is a draft
   			if(array_key_exists('delete', $args) && $args['delete'] == true) {
   				$page->deleteHtml();
   				$page->deleteMarkdown();
   				continue;
   			}
   			if(array_key_exists('draft', $args) && $args['draft'] == true){
   				$page->deleteHtml();
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
   			
   			if(!file_exists(HTML_PATH.$args['path'])){
   				mkdir(HTML_PATH.$args['path'], 0777, true);
   			}
   			//var_dump($args);
   			
   			$args['markdown'] 	= $page->getBody();
   			$args['content'] 	= $page->getHtml();
   			
   			$args['page']		= $page;
   			
   			$html = $template->render($args);
   			
   			file_put_contents(HTML_PATH.$args['path'].'/index.html', $html);
   		}
   		
   		return $response;
   }
}