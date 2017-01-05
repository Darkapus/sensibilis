<?php 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response, $args) {
    $target = file_get_contents(__DIR__ . '/View/Markdown/index.md');
    
    $args['markdown'] = $target;
    
    $tbl = explode("\n", $target);
    
    $content = '';
    $stop = -1;
    
    while(true){
    	$row = array_shift($tbl);
    	
    	if(is_null($row)) break;
    	
    	if($row =='---') {
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
    
    $args['content'] = $content;
    
	return $this->renderer->render($response, 'article.html', $args);
});


// outils de gestion de contenu md
$app->get('/edit'		, '\Sensibilis\Controller\Deoployer:create');
$app->get('/sitemap'	, '\Sensibilis\Controller\Deoployer:create');
$app->get('/html'		, '\Sensibilis\Controller\Deoployer:create');
$app->get('/md'			, '\Sensibilis\Controller\Deoployer:create');
$app->get('/tags'		, '\Sensibilis\Controller\Deoployer:create');
$app->get('/categories'	, '\Sensibilis\Controller\Deoployer:create');


// deploy all
$app->put('/deploy'		, '\Sensibilis\Controller\Deoployer:create');
// deployer le sitemap pour google
$app->put('/sitemap'	, '\Sensibilis\Controller\Deoployer:create');
// sauvegarde en .html
$app->put('/html'		, '\Sensibilis\Controller\Deoployer:create');
// sauvegarde du markdonw
$app->put('/md'			, '\Sensibilis\Controller\Deoployer:create');

$app->put('/tags'		, '\Sensibilis\Controller\Deoployer:create');
$app->put('/categories'	, '\Sensibilis\Controller\Deoployer:create');


// la sauvegarde deploie uniquement des md dans le repertoire source



// deployer md vers source statique à choisir dans le PUT
