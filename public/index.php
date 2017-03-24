<?php
/**
 * Created by PhpStorm.
 * User: kasi
 * Date: 17.03.2017
 * Time: 14:30
 */
header('X-Frame-Options: GOFORIT');
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
