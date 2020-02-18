<?php

namespace App\Middlewares;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthenticationMiddleware implements MiddlewareInterface {
 public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {

    $sessionUserId = $_SESSION['userId'] ?? null;
    $needsAuth = $_SESSION['needsAuth'];
    if($needsAuth && !$sessionUserId) {
        $_SESSION['routeProtected']= 'Route protected, you need to be logged.';
        return new RedirectResponse('/login');
    }

    return $handler->handle($request);
 }
}