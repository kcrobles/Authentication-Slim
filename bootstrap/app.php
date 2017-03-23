<?php

use Respect\Validation\Validator as v;

session_start();

require __DIR__."/../vendor/autoload.php";

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'blog',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix' => ''
        ]
    ]
]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;

$capsule->addConnection($container['settings']['db']);

$capsule->setAsGlobal();

$capsule->bootEloquent();

$container['db'] = function($container) use ($capsule) {
    return $capsule;
};

$container['view'] = function($container) {
    $view = new \Slim\Views\Twig(__DIR__.'/../resources/views', [
        'cache' => false
    ]);
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension($container['router'], $basePath));

    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->check(),
        'user' => $container->auth->user()
    ]);

    return $view;
};

$container['csrf'] = function($container) {
    return new \Slim\Csrf\Guard;
};

$container['validator'] = function($container) {
    return new \App\Validation\Validator;
};

$container['auth'] = function($container) {
    return new \App\Auth\Auth;
};

$container['HomeController'] = function($container){
    return new \App\Controllers\HomeController($container);
};

// Middlewares
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));

$app->add(new \App\Middleware\OldInputMiddleware($container));

$app->add(new \App\Middleware\CsrfViewMiddleware($container));

$app->add($container->csrf);


v::with('App\\Validation\\Rules\\');


require __DIR__."/../app/routes.php";
