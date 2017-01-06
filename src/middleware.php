<?php
$app->add(function ($request, $response, $next) {
	if($request->isPost() && $request->getParam('login') == LOGIN && $request->getParam('password') == PASSWD) {
		$_SESSION['needlog'] = false;
	}
	
	// on verifie si loggé
	if(!array_key_exists('needlog', $_SESSION)) {
		$_SESSION['needlog'] = true;
	}
	
	if($_SESSION['needlog']) {
		$this->view->render($response, 'login.html');
	}
	else{
		$response = $next($request, $response);
	}
	
	if($response->getStatusCode() == '404') {
		header('Location: '.ADMIN_PATH.'edit?path='.$_SERVER['REQUEST_URI']);
		exit;
	}
	
	return $response;
});