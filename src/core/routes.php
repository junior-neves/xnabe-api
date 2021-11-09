<?php

use Core\DependencyProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

$request = Request::createFromGlobals();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {

    $r->post('/reset', ['App\Controllers\ResetController', 'reset']);
    $r->get('/balance', ['App\Controllers\AccountController', 'getBalance']);
    $r->post('/event', ['App\Controllers\EventController', 'handler']);
});


$uri = parse_url($request->getRequestUri(), PHP_URL_PATH);
$routeInfo = $dispatcher->dispatch($request->getMethod(), $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $response = new JsonResponse();
        $response->setStatusCode(Response::HTTP_NOT_FOUND);
        $response->send();
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        $response = new JsonResponse();
        $response->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED);
        $response->send();
        break;
    case FastRoute\Dispatcher::FOUND:
        $controllerClass = $routeInfo[1][0];
        $method = $routeInfo[1][1];

        $controller = DependencyProvider::getDependencies($controllerClass);

        /* @var Symfony\Component\HttpFoundation\JsonResponse $response  */
        $response = $controller->{$method}($request);
        $response->send();
        break;
}
