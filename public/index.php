<?php
/**
 * Website front door : use light home made framework to manage website.
 * Create a App from App's class and run that class.  
 */
require '../vendor/autoload.php';
$app = new \Ezway\App();
$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
\Http\Response\send($response);


