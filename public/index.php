<?php
ini_set('display_errors', 1);
ini_set('display_startup_error', 1);
error_reporting(E_ALL);
require_once '../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;
use Zend\Diactoros\Response\RedirectResponse;

$capsule = new Capsule;
session_start();

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

// Jobs

$map->get('addjob', '/phpbasics/curso/jobs/add', [
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getAddJobAction',
    'auth' => true,
]);

$map->post('saveJob', '/phpbasics/curso/jobs/add', [
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getAddJobAction',
    'auth' => true,
]);

// Projects

$map->get('addProject', '/phpbasics/curso/projects/add', [
    'controller' => 'App\Controllers\ProjectsController',
    'action' => 'getAddProjectAction',
    'auth' => true,
]);

$map->post('saveProject', '/phpbasics/curso/projects/add', [
    'controller' => 'App\Controllers\ProjectsController',
    'action' => 'getAddProjectAction',
    'auth' => true,
]);

// Users

$map->get('addUser', '/phpbasics/curso/users/add', [
    'controller' => 'App\Controllers\UsersController',
    'action' => 'getAddUserAction',
    'auth' => true,
]);

$map->post('saveUser', '/phpbasics/curso/users/add', [
    'controller' => 'App\Controllers\UsersController',
    'action' => 'getAddUserAction',
    'auth' => true,
]);


// Login

$map->get('loginForm', '/phpbasics/curso/login', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'getLogin',
]);

$map->post('authUser', '/phpbasics/curso/auth', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'postLogin',
]);

// Logout

$map->get('logout', '/phpbasics/curso/logout', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'getLogout',
    'auth' => true,
]);

// Admin

$map->get('admin', '/phpbasics/curso/admin', [
    'controller' => 'App\Controllers\AdminController',
    'action' => 'getIndex',
    'auth' => true,
]);

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if (!$route) {
    echo 'No route';
} else {
    $hadlerData = $route->handler;
    $controllerName = $hadlerData['controller'];
    $actionName = $hadlerData['action'];
    $needsAuth = $hadlerData['auth'] ?? false;
    $sessionUserId = $_SESSION['userId'] ?? null;

    if($needsAuth && !$sessionUserId) {
        $_SESSION['routeProtected']= 'Route protected, you need to be logged.';
        $response = new RedirectResponse('/phpbasics/curso/login');
    } else {
        $controller = new $controllerName;
        $response = $controller->$actionName($request);
    }

    foreach ($response->getHeaders() as $name => $values) {
        foreach ($values as $value) {
           header(sprintf('%s: %s', $name, $value), false);
        }
    }

    http_response_code($response->getStatusCode());
    echo $response->getBody();
}
