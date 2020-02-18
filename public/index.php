<?php
ini_set('display_errors', 1);
ini_set('display_startup_error', 1);
error_reporting(E_ALL);
require_once '../vendor/autoload.php';

use App\Middlewares\AuthenticationMiddleware;
use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;
use DI\Container;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter as EmitterSapiEmitter;
use WoohooLabs\Harmony\Harmony;
use WoohooLabs\Harmony\Middleware\DispatcherMiddleware;
use WoohooLabs\Harmony\Middleware\LaminasEmitterMiddleware;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;

$capsule = new Capsule;
$container = new Container();
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

$request = ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();
$map->get('index', '/', [
    'App\Controllers\IndexController',
    'indexAction',
]);

// Jobs

$map->get('indexJob', '/jobs', [
    'App\Controllers\JobsController',
    'indexAction',
    'auth' => true,
]);

$map->get('deleteJob', '/jobs/delete', [
    'App\Controllers\JobsController',
    'deleteAction',
    'auth' => true,
]);

$map->get('forceDeleteJob', '/jobs/forcedelete', [
    'App\Controllers\JobsController',
    'forceDeleteAction',
    'auth' => true,
]);

$map->get('restoreJob', '/jobs/restore', [
    'App\Controllers\JobsController',
    'restoreAction',
    'auth' => true,
]);

$map->get('addjob', '/jobs/add', [
    'App\Controllers\JobsController',
    'getAddJobAction',
    'auth' => true,
]);

$map->post('saveJob', '/jobs/add', [
    'App\Controllers\JobsController',
    'getAddJobAction',
    'auth' => true,
]);

// Projects

$map->get('addProject', '/projects/add', [
    'App\Controllers\ProjectsController',
    'getAddProjectAction',
    'auth' => true,
]);

$map->post('saveProject', '/projects/add', [
    'App\Controllers\ProjectsController',
    'getAddProjectAction',
    'auth' => true,
]);

// Users

$map->get('addUser', '/users/add', [
    'App\Controllers\UsersController',
    'getAddUserAction',
    'auth' => false,
]);

$map->post('saveUser', '/users/add', [
    'App\Controllers\UsersController',
    'getAddUserAction',
    'auth' => false,
]);


// Login

$map->get('loginForm', '/login', [
    'App\Controllers\AuthController',
    'getLogin',
]);

$map->post('authUser', '/auth', [
    'App\Controllers\AuthController',
    'postLogin',
]);

// Logout

$map->get('logout', '/logout', [
    'App\Controllers\AuthController',
    'getLogout',
    'auth' => true,
]);

// Admin

$map->get('admin', '/admin', [
    'App\Controllers\AdminController',
    'getIndex',
    'auth' => true,
]);


$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);


        $hadlerData = $route->handler;
        $needsAuth = $hadlerData['auth'] ?? false;
        $_SESSION['needsAuth'] = $needsAuth;
        
        $harmony = new Harmony($request, new Response());
        $harmony
        ->addMiddleware(new LaminasEmitterMiddleware(new EmitterSapiEmitter))
        ->addMiddleware(new AuthenticationMiddleware)
        ->addMiddleware(new Middlewares\AuraRouter($routerContainer))
        ->addMiddleware(new DispatcherMiddleware($container, 'request-handler'))
        ->run();
    // }
    //     // $controller = $container->get($controllerName);
    //     // $response = $controller->$actionName($request);
    // }

//     foreach ($response->getHeaders() as $name => $values) {
//         foreach ($values as $value) {
//            header(sprintf('%s: %s', $name, $value), false);
//         }
//     }

//     http_response_code($response->getStatusCode());
//     echo $response->getBody();
// }
