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
$app->post('/api/main', '\Controller\MainController:getData');
$app->post('/api/adressen/update', '\Controller\AdressenController:update');
$app->post('/api/adressen/getdata', '\Controller\AdressenController:getdata');
$app->post('/api/adressen/create', '\Controller\AdressenController:create');
$app->post('/api/adressen/delete', '\Controller\AdressenController:delete');
$app->post('/api/plan/gettour', '\Controller\PlanController:getTour');
$app->post('/api/plan/add', '\Controller\PlanController:add');
$app->post('/api/plan/delete', '\Controller\PlanController:delete');
$app->post('/api/plan/recalc', '\Controller\PlanController:recalc');
$app->post('/api/plan/setorder', '\Controller\PlanController:setorder');
$app->post('/api/touren/load', '\Controller\TourenController:load');
$app->post('/api/touren/create', '\Controller\TourenController:create');
$app->post('/api/touren/delete', '\Controller\TourenController:delete');
$app->post('/api/touren/update', '\Controller\TourenController:update');

$container = $app->getContainer();
$container['db'] = function(\Slim\Container $container){
    $cfg = $container->get('config')['db'];
    $host = $cfg['host'];
    $name = $cfg['dbname'];
    $user = $cfg['user'];
    $password = $cfg['password'];
    $dns = "mysql:dbname=$name;host=$host";
    $pdo = new \PDO($dns,$user,$password,[PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'']);
    return $pdo;
};

$app->run();