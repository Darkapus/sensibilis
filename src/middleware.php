<?php
$app->add(function ($request, $response, $next) {
	if($request->isPost()) {
		
		if($request->getParam('login') && $request->getParam('password')){
			$login = $request->getParam('login');
			$password = $request->getParam('password');
			header('Location: '.$_SERVER['HTTP_REFERER']);
			if($login == LOGIN && $password == PASSWD){
				$_SESSION['needlog'] = false;
			}
			else{
				
				\Sensibilis\Model\Service\Site::requireConfiguration();
				
				if(file_exists(MARKDOWN_PATH.'/user/'.$login.'.md')){
					
					$args = \Sensibilis\Model\Service\Markdown::parseToArgs(file_get_contents(MARKDOWN_PATH.'/user/'.$login.'.md'));
					
					$pass = false;
					
					if($args['crypt'] == 'plain'){
						$pass = ($password == $args['password']);
					}
					if($args['crypt'] == 'sha1'){
						$pass = (sha1($password) == $args['password']);
					}
					
					if($pass){
						$_SESSION['user'] 		= $args;
						$_SESSION['needlog']	= false;
					}
				}
			}
			
			exit;
		}
	}
	
	//$route = explode('/', str_replace(ADMIN_PATH, '', $request->getUri()->getPath()));
	
	// on verifie si loggé
	if(!array_key_exists('needlog', $_SESSION)) {
		$_SESSION['needlog'] = true;
	}
	
	if(
		($_SESSION['needlog'] && strpos($_SERVER['REQUEST_URI'], ADMIN_PATH) !== false) /*||
		(array_key_exists('user', $_SESSION) && strpos($_SERVER['REQUEST_URI'], ADMIN_PATH) !== false && !in_array($route[0], $_SESSION['user']['access']))*/
	) {
		session_destroy();
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