<?php
namespace Ezway\Core;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;
use Ezway\Config\Routes;
use FastRoute;

/**
 * Industrialisation of nikic/fastRoute : https://github.com/nikic/FastRoute
 */
class Router
{
    /**
     * @param String extension of web routes
     */
    private static $typeOfWeb = "web";

    /**
     * @param String extension of api routes
     */
    private static $typeOfApi = "api";
    
    /**
     * @param String extension of api routes
     */
    private static $controllerNamespace = "Ezway\\Controllers\\";

    /**
     * @param String extension of api routes
     */
    private static $apiNamespace = "Ezway\\API\\";
    
       

    /**
     * @param FastRoute\simpleDispatcher
     */
    private $dispatcher;

    /**
     * initialization of dispatcher with all routes.
     */
    public function __construct()
    {
        $this->dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
            $this->registerRoutes(Routes::$web, $r, Self::$typeOfWeb);
            $this->registerRoutes(Routes::$api, $r, Self::$typeOfWeb);
        });
    }

    /**
     * Find by routes the controller and function associate to the route.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface controller's action response.
     */
    public function invoke(ServerRequestInterface $request): ResponseInterface
    {
        $httpMethod = $request->getMethod();
        $uri = $request->getUri()->getPath();

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);
        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                $response = (new Response())->withStatus("404");
                $response->getBody()->write("Erreur 404");
                return $response;
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $response = (new Response())->withStatus("404");
                return $response;
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                [$typeOfRoute, $controller, $action] = explode('.', $handler);
                return $this->execute($controller, $action, $typeOfRoute, $request);
                break;
        }
    }

    /**
     * Execute function in unknow controller.
     */
    private function execute(string $controller, string $action, string $typeOfRoute, ServerRequestInterface $request): ResponseInterface{
        //TODO : check if class exist + manage API
        $fullPathToController = Self::$controllerNamespace.$controller;
        $unknowController = new $fullPathToController();
        return $unknowController->$action($request);
    }

    /**
     * Private function who register Routes from config by type of routes.
     * @param [] $routes array of routes to register
     * @param FastRoute\RouteCollector memory access to RouteCollector
     * @param string $typeOfRoute type of register
     */
    private function registerRoutes(array $routes, FastRoute\RouteCollector &$r, string $typeOfRoute)
    {
        foreach ($routes as $route) {
            $r->addRoute($route['method'], $route['path'], $typeOfRoute.".".$route['callback']);
        }
    }
}
