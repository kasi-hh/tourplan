<?php
/**
 * Created by PhpStorm.
 * User: kasi
 * Date: 17.03.2017
 * Time: 14:30
 */
define('APP_BASE', dirname(__DIR__));
//$_SERVER['SCRIPT_NAME'] = '/index.php';
$autoloader = include '../vendor/autoload.php';
$autoloader->addPsr4('Controller\\',APP_BASE.'/app/controller');
$autoloader->addPsr4('App\\',APP_BASE.'/app/src');

$app = new \Slim\App(new Slim\Container(include APP_BASE . '/config/config.php'));
$app->get('/', function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
    return $response->withHeader('Content-type', 'text/html')->write(include 'index.html');
});
$app->post('/api/distance', '\Controller\GoogleController:getDistance');
$app->run();
