<?php 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response, $args) {
	
    return $this->renderer->render($response, 'article.html', \Sensibilis\Model\Service\Markdown::parseToArgs(file_get_contents(MARKDOWN_PATH . '/home.md')));
});


// outils de gestion de contenu md
$app->get(ADMIN_PATH.'edit'		, function (Request $request, Response $response, $args) {
	
	if($path = $request->getParam('path', null)){
		$path = $path.'.md';
	}
	
	return $this->renderer->render($response, 'editor.html', \Sensibilis\Model\Service\Markdown::parseToArgs(file_get_contents(MARKDOWN_PATH.$path)));
});
$app->post(ADMIN_PATH.'edit'		, function (Request $request, Response $response, $args) {
	$content = $request->getParam('content');
	$args = \Sensibilis\Model\Service\Markdown::parseToArgs($content);
	
	// recursive directory creation
	$path = $args['path'];
	
	if($path){
		mkdir(MARKDOWN_PATH.$path, 0777, true);
	}
	
	// create md content not deployed
	header('Location: '.ADMIN_PATH.'edit?path='.$args['path']);
	file_put_contents(MARKDOWN_PATH.$path.'.md', $content);
	
	exit;
});
$app->get(ADMIN_PATH.'sitemap'	, '\Sensibilis\Controller\Deployer:todo');
$app->get(ADMIN_PATH.'html'		, '\Sensibilis\Controller\Deployer:todo');
$app->get(ADMIN_PATH.'md'			, '\Sensibilis\Controller\Deployer:todo');
$app->get(ADMIN_PATH.'tags'		, '\Sensibilis\Controller\Deployer:todo');
$app->get(ADMIN_PATH.'categories'	, '\Sensibilis\Controller\Deployer:todo');


// deploy all
$app->put(ADMIN_PATH.'deploy'		, '\Sensibilis\Controller\Deployer:todo');
// deployer le sitemap pour google
$app->put(ADMIN_PATH.'sitemap'	, '\Sensibilis\Controller\Deployer:todo');
// sauvegarde en .html
$app->put(ADMIN_PATH.'html'		, '\Sensibilis\Controller\Deployer:todo');
// sauvegarde du markdonw
$app->put(ADMIN_PATH.'md'			, '\Sensibilis\Controller\Deployer:todo');

$app->put(ADMIN_PATH.'tags'		, '\Sensibilis\Controller\Deployer:todo');
$app->put(ADMIN_PATH.'categories'	, '\Sensibilis\Controller\Deployer:todo');


// la sauvegarde deploie uniquement des md dans le repertoire source



// deployer md vers source statique à choisir dans le PUT
