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
   		if(array_key_exists('user', $_SESSION) && !in_array($args['site'], $_SESSION['user']['access'])){
   			$response->write('impossible');
   			return $response;
   		}
   	
   		\Sensibilis\Model\Service\Site::requireConfiguration($args);
   		
   		$page = new \Sensibilis\Model\Document\Page(MARKDOWN_PATH.$request->getParam('path', HOME_PATH).'.md');
   		
   		$args = $page->getHeaders();
   		
   		$args['markdown'] = $page->getMarkdown();
   		
   		$today = new \DateTime();
   		
   		if(!$args['markdown']){
   			$args['markdown'] = '---'.PHP_EOL.'created: '.$today->format('Y-m-d H:i:s').PHP_EOL.'draft: true'.PHP_EOL.'path: '.$request->getParam('path').PHP_EOL.'site: '.$args['site'].PHP_EOL.PHP_EOL.'---';
   		}
   		
   		if($_SESSION['user']){
   			$args['sites'] = $_SESSION['user']['access'];
   		}
   		else{
   			$args['sites'] = \Sensibilis\Model\Service\Site::listConfiguration();
   		}
   		
   		$args['files'] = \Sensibilis\Model\Service\Site::listMarkdown();
   		
   		$pages = \Sensibilis\Model\Service\Site::listAllPage();
   		
   		$pageWithoutParent = [];
   		
   		foreach($pages as $p){
   			if(!$p->getParent()){
   				$pageWithoutParent[] = $p;
   			}
   		}
   		
   		$args['pages'] = $pageWithoutParent;
   		
   		$this->app->view->render($response, 'editor.html', $args);
   		return $response;
   }
   
   public function save(Request $request, Response $response, $args){
   		$content = $request->getParam('content');
		$args = \Sensibilis\Model\Service\Markdown::parseToArgs($content);
		
		\Sensibilis\Model\Service\Site::requireConfiguration($args);
		
		// recursive directory creation
		$path = $args['path'];
		
		if($path && !file_exists(MARKDOWN_PATH.$path)){
			mkdir(MARKDOWN_PATH.$path, 0777, true);
		}
		
		// create md content not deployed
		header('Location: '.$_SERVER['HTTP_REFERER']);
		file_put_contents(MARKDOWN_PATH.$path.'.md', $content);
		return $response;
   }
}