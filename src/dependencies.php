<?php

$container = $app->getContainer();

// view renderer
$container['renderer'] = function (\Slim\Container $container) {
    $settings = $container->get('settings')['renderer'];
    
    $twig = new Slim\Views\Twig($settings['template_path']);
    
    return $twig;
};

// monolog
$container['logger'] = function (\Slim\Container $container) {
    $settings = $container->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};


// Register component on container
$container['view'] = function (\Slim\Container $container) {
	$settings = $container->get('settings')['renderer'];
	
    $view = new \Slim\Views\Twig($settings['template_path'], [
        
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension($container['router'], $basePath));
	
    return $view;
};
