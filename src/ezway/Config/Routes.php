<?php

namespace Ezway\Config;

/**
 * Manage all existing routes 
 */
class Routes{

    /**
     * Add web routes like that: 
     * ['method' => 'METHODE USE', 'path' => 'ROUTE', 'callback' => 'CONTROLLER.FUNCTION']
     */
    static $web = [
        ['method' => 'GET', 'path' => '/', 'callback' => 'Example.show'],
        ['method' => 'GET', 'path' => '/example', 'callback' => 'Example.show'],
    ];

    /*
    * TODO : 
    */
    static $api = [];
}
