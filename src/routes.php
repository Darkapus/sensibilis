<?php 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response, $args) {
    header('Location: '.ADMIN_PATH.DEFAULT_CONF.'/edit');
    exit;
});



$app->get('/icon/user/{string}'			, '\Sensibilis\Controller\Image:icon');

// outils de gestion de contenu md
$app->get(ADMIN_PATH.'edit'			, '\Sensibilis\Controller\Editor:form');
$app->get(ADMIN_PATH.'{site}/edit'			, '\Sensibilis\Controller\Editor:form');
$app->post(ADMIN_PATH.'edit'		, '\Sensibilis\Controller\Editor:save');
$app->post(ADMIN_PATH.'{site}/edit'		, '\Sensibilis\Controller\Editor:save');

$app->get(ADMIN_PATH.'html'			, '\Sensibilis\Controller\Deployer:html');
$app->get(ADMIN_PATH.'{site}/html'			, '\Sensibilis\Controller\Deployer:html');

$app->get(ADMIN_PATH.'sitemap'	, '\Sensibilis\Controller\Deployer:todo');

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
