<?php
// DIC configuration
use Aptoma\Twig\Extension\MarkdownExtension;
use Aptoma\Twig\Extension\MarkdownEngine;

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    //$engine = new MarkdownEngine\MichelfMarkdownEngine();
    $twig = new Slim\Views\Twig($settings['template_path']);
    //$twig->addExtension(new MarkdownExtension($engine));
    return $twig;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};


// Register component on container
$container['view'] = function ($container) {
	$settings = $container->get('settings')['renderer'];
	
    $view = new \Slim\Views\Twig($settings['template_path'], [
        /*'cache' => $settings['template_cache']*/
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};