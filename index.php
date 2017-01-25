<?php
require 'vendor/autoload.php';

require __DIR__ . '/src/config.php';
session_start();

$settings = require __DIR__ . '/src/settings.php';

$app = new \Slim\App($settings);

// registers
\Sensibilis\Model\Service\Factory::register('Markdown'	, 'Sensibilis\Model\Service\Markdown');
\Sensibilis\Model\Service\Factory::register('Site'		, 'Sensibilis\Model\Service\Site');

require __DIR__ . '/src/dependencies.php';

require __DIR__ . '/src/middleware.php';

require __DIR__ . '/src/routes.php';

$app->run();
