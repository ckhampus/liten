<?php
require_once('Core.php');
require_once('Query.php');
require_once('Request.php');
require_once('Route.php');
require_once('RouteCollection.php');
require_once('Router.php');
require_once('Url.php');

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
        // Initialize the Core.
        $core = new Core();
        $this->routes = $core->getRouteCollection();
        $this->router = $core->getRouter();
    }

    private function init() {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }
    
    // Properties
    
    private $core   = NULL;
    private $routes = NULL;
    private $router = NULL;
    
    // Methods
    
    /**
     * Associate a GET request
     * with a callback and a relative URL.
     *
     * @param string $route
     * @param callback $callbacks
     */
    public static function get($route, $callbacks) {
        self::init()->routes[] = new Route($route, 'GET', $callbacks);
    }

    /**
     * Associate a POST request
     * with a callback and a relative URL.
     *
     * @param string $route
     * @param callback $callbacks
     */
    public static function post($route, $callbacks) {
        self::init()->routes[] = new Route($route, 'POST', $callbacks);
    }

    /**
     * Associate a PUT request
     * with a callback and a relative URL.
     *
     * @param string $route
     * @param callback $callbacks
     */
    public static function put($route, $callbacks) {
        self::init()->routes[] = new Route($route, 'PUT', $callbacks);
    }

    /**
     * Associate a DELETE request
     * with a callback and a relative URL.
     *
     * @param string $route
     * @param callback $callbacks
     */
    public static function delete($route, $callbacks) {
        self::init()->routes[] = new Route($route, 'DELETE', $callbacks);
    }
    
    /**
     * run 
     * 
     * @return void
     */
    public static function run() {
        self::init()->router->execute();
    }
}

/**
 * Returns the currents script filename only. 
 * 
 * @return string
 */
if(!function_exists('get_script_name')) {
    function get_script_name() {
        $string = $_SERVER['SCRIPT_NAME'];
        $string = substr($string, strripos('/', $string));
        
        return $string;
    }
}

/**
 * Get the current URL. 
 * 
 * @return string
 */
if(!function_exists('get_current_url')) {
    function get_current_url() {
        $url = 'http';

        if (isset($_SERVER['HTTPS'])) {
            $url .= 's';
        }
        
        $url .= '://'.$_SERVER['SERVER_NAME'];
        $url .= $_SERVER['REQUEST_URI'];
        
        return $url;
    }
}