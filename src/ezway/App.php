<?php

namespace Ezway;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;
use Ezway\Core\Router;

/*
* Main class: 
* Manage request. 
*/
class App
{

    /**
     * Choose action we need to do when someone do a request to the website.
     * @param ServerRequestInterface $request  from Guzzlehttp request send
     * @return ResponseInterface implement a PSR7 response from Guzzlehttp
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $router = new Router(); 
        $response = new Response();
        return $router->invoke($request);          
        ;
    }
}
