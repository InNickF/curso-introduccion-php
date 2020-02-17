<?php
ini_set('display_errors', 1);
ini_set('display_startup_error', 1);
error_reporting(E_ALL);
require_once '../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;
use Zend\Diactoros\Response\RedirectResponse;

$capsule = new Capsule;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

session_start();

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => getenv('DB_HOST'),
    'database'  => getenv('DB_DATABASE'),
    'username'  => getenv('DB_USERNAME'),
    'password'  => getenv('DB_PASS'),
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
$map->get('index', '/', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'indexAction',
]);

// Jobs

$map->get('addjob', '/jobs/add', [
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getAddJobAction',
    'auth' => true,
]);

$map->post('saveJob', '/jobs/add', [
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getAddJobAction',
    'auth' => true,
]);

// Projects

$map->get('addProject', '/projects/add', [
    'controller' => 'App\Controllers\ProjectsController',
    'action' => 'getAddProjectAction',
    'auth' => true,
]);

$map->post('saveProject', '/projects/add', [
    'controller' => 'App\Controllers\ProjectsController',
    'action' => 'getAddProjectAction',
    'auth' => true,
]);

// Users

$map->get('addUser', '/users/add', [
    'controller' => 'App\Controllers\UsersController',
    'action' => 'getAddUserAction',
    'auth' => false,
]);

$map->post('saveUser', '/users/add', [
    'controller' => 'App\Controllers\UsersController',
    'action' => 'getAddUserAction',
    'auth' => false,
]);


// Login

$map->get('loginForm', '/login', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'getLogin',
]);

$map->post('authUser', '/auth', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'postLogin',
]);

// Logout

$map->get('logout', '/logout', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'getLogout',
    'auth' => true,
]);

// Admin

$map->get('admin', '/admin', [
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
        $response = new RedirectResponse('/login');
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
