<?php
require_once('Url.php');
require_once('Router.php');
require_once('Request.php');
require_once('Query.php');

/**
 * Liten 
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
final class Liten {
    private static $instance;

    private function __construct() {
        $this->router = Router::instance();
    }

    private function init() {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }
    
    // Properties
    
    private $router;
    
    // Methods
    
    /**
     * Associate a GET request
     * with a callback and a relative URL.
     *
     * @param string $route
     * @param callback $callbacks
     */
    public static function get($route, $callbacks) {
        $router = self::init()->router;
        $router->addRoute($route, 'GET', $callbacks);
    }

    /**
     * Associate a POST request
     * with a callback and a relative URL.
     *
     * @param string $route
     * @param callback $callbacks
     */
    public static function post($route, $callbacks) {
        $router = self::init()->router;
        $router->addRoute($route, 'POST', $callbacks);
    }

    /**
     * Associate a PUT request
     * with a callback and a relative URL.
     *
     * @param string $route
     * @param callback $callbacks
     */
    public static function put($route, $callbacks) {
        $router = self::init()->router;
        $router->addRoute($route, 'PUT', $callbacks);
    }

    /**
     * Associate a DELETE request
     * with a callback and a relative URL.
     *
     * @param string $route
     * @param callback $callbacks
     */
    public static function delete($route, $callbacks) {
        $router = self::init()->router;
        $router->addRoute($route, 'DELETE', $callbacks);
    }
    
    /**
     * run 
     * 
     * @return void
     */
    public static function run() {
        $router = self::init()->router;
        $router->execute();
    }
}