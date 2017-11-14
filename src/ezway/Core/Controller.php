<?php 
namespace Ezway\Core;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;
use Ezway\Config\Injectors;
use Ezway\Config\Settings;

/**
 * Master class of Controller manage: 
 * -> rendering
 * -> Global/Cross controller injection
 */
class Controller{   

    static private $twigExt = ".html.twig"; 
    static private $viewsPath = "../src/ezway/views"; 
    
    /**
     * @param Twig_Environment
     */
    private $twig; 
    /**
     * @param Twig_Environment
     */
    private $loader;

    /**
     * @param [] path to style
     */
    private $styles = []; 

    /**
     * @param [] path to javascript
     */
    private $scripts = []; 

    /**
     * @param String 
     */
    private $pageName;
    
    public function __construct(){
        //Initialization: twig template  
        $this->loader = new \Twig_Loader_Filesystem(Self::$viewsPath);
        $this->twig = new \Twig_Environment($this->loader, array());
        //Initialization of css/js
        $this->scripts = Injectors::$javascript;
        $this->styles = Injectors::$css;    
        //Initialization page name
        $this->setPageName();
    }

    /**
     * Render the view and create the response 
     * @param string $templateName path and file name (no extension, all view need to be on .html.twig)
     * @param array $parameters all parameters need on view.
     */
    protected function render(string $templateName, array $parameters = array()): ResponseInterface
    {
        $response = (new Response())->withStatus("200");
        $parameters = array_merge($parameters, $this->getOverallParameters()); 
        $response->getBody()->write($this->twig->render($templateName.Controller::$twigExt, $parameters));
        return $response;
    }
    

    protected function setPageName(string $pageName = ''){
        $this->pageName = ($pageName === '')?Settings::$appName:$pageName." - ".Settings::$appName;
    }

    /**
     * return overall parameters (ex: css, js) need to be injected on all page
     * @param array $parameters all parameters need on all views.
     */
    private function getOverallParameters(){
        $overall = [];
        $overall['scripts'] = $this->scripts;
        $overall['styles'] = $this->styles;
        $overall['pageName'] = $this->pageName;
        return $overall;
    }

    
}