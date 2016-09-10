<?php
// DIC configuration

use \App\Controller\WidgetController;

$container = $app->getContainer();

// view renderer
/**
 * @param $c
 * @return \Slim\Views\PhpRenderer
 */
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};

/**
 * @param $c
 * @return PDO
 */
$container['pdo'] = function ($c) {

    $db = $c['settings']['db'];

    $pdo = new PDO('mysql:host='.$db['host'].';dbname='.$db['database'], $db['username'], $db['password']);

    return $pdo;
};

