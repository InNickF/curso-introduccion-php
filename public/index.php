<?php
ini_set('display_errors', 1);
ini_set('display_startup_error', 1);
error_reporting(E_ALL);
require_once '../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'php_basic',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();
$map->get('index', '/phpbasics/curso/', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'indexAction',
]);

$map->get('addjob', '/phpbasics/curso/jobs/add', [
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getAddJobAction',
]);

$map->post('saveJob', '/phpbasics/curso/jobs/add', [
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getAddJobAction',
]);

$map->get('addProject', '/phpbasics/curso/projects/add', [
    'controller' => 'App\Controllers\ProjectsController',
    'action' => 'getAddProjectAction',
]);

$map->post('saveProject', '/phpbasics/curso/projects/add', [
    'controller' => 'App\Controllers\ProjectsController',
    'action' => 'getAddProjectAction',
]);


$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if (!$route) {
    echo 'No route';
} else {
    $hadlerData = $route->handler;
    $controllerName = $hadlerData['controller'];
    $actionName = $hadlerData['action'];

    $controller = new $controllerName;
    $response = $controller->$actionName($request);

    echo $response->getBody();
}
