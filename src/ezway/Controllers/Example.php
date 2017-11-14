<?php
namespace Ezway\Controllers;

use Ezway\Core\Controller;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Controller: Manage contact demand : show form, send mails. 
 */
class Example extends Controller{

    public function show(ServerRequestInterface $request): ResponseInterface
    {
        $this->setPageName('Example');
        return $this->render('index',[]);
    }

}