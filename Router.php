<?php
/**
 * Router 
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class Router {
    private static $instance = NULL;
    
    private function __construct() {}
    
    public function instance() {
        if (!isset(self::$instance)) {        
            self::$instance = new self; 
        }
        
        return self::$instance;
    }
    
    // Properties
    
    private $routes = array();
    private $regexp = array(
        '/:[a-zA-Z_][a-zA-Z0-9_]*/' => '[\w]+',
        '/\*/' => '.+'
    );
    
    // Methods
    
    /**
     * Add a route.
     * 
     * @param string $uri 
     * @param string $method 
     * @param callback $callback
     */
    public function addRoute($uri, $method, $callbacks) {
    
        $this->routes[] = new Route($uri, $method, $callbacks);
        /*
        // Check if there are multiple callback
        // defined and split them then into an array.
        if (is_string($callback) && strpos($callback, '|')) {
            $callbacks = explode('|', $callback);
        }
        else {
            $callbacks[] = $callback;
        }
        
        $uri = '/'.trim($uri, '/');
        
        // Escape the forwardslashes.
        $regexp = str_replace('/', '\/', $uri);
        // Convert wild-cards to regular expressions.
        foreach ($this->regexp as $key => $value) {
            $regexp = preg_replace($key, $value, $regexp);
        }
        
        // Add route to array.
        $this->routes[] = array(
            'uri'       => $uri,
            'regexp'    => $regexp,
            'method'    => $method,
            'callbacks' => $callbacks
        );
        */
    }
    
    /**
     * Executes the router. 
     * 
     * @return bool
     */
    public function execute() {
        // The requested url.
        $request = new Request();
        
        // The base url.
        $base = new Url('http://localhost/dev');
        
        $path = substr(
            $request->getUrl()->getPath(), 
            strlen($base->getPath())
        );
        
        // Get the values for the arguments by computing
        // the difference between the route and the actual uri.
        $arguments = array_diff(explode('/', $path), explode('/', $request->getUrl()->getPath()));
        
        /*
        foreach(self::$instance->routes as $route) {
            // Check if the requested http method is the
            // same as the method specified in the route.            
            if ($request->getMethod() === $route['method']) {
                // Check if the requested uri matches the specified route.
                
                if (preg_match('/^'.$route['regexp'].'$/', $path)) {
                    foreach ($route['callbacks'] as $callback) {
                        if (is_callable($callback)) {
                            call_user_func_array($callback, $arguments);
                        }
                    }
                    
                    // Return TRUE if route matched.
                    return TRUE;
                }
            }
        }
        */
        
        foreach(self::$instance->routes as $route) {
            // Check if the requested http method is the
            // same as the method specified in the route.            
            if ($request->getMethod() === $route->getMethod()) {
                // Check if the requested uri matches the specified route.
                
                if (preg_match('/^'.$route->getUri(TRUE).'$/', $path)) {
                    foreach ($route->getCallbacks() as $callback) {
                        if (is_callable($callback)) {
                            call_user_func_array($callback, $arguments);
                        }
                    }
                    
                    // Return TRUE if route matched.
                    return TRUE;
                }
            }
        }
        
        // Return FALSE if no route matched.
        return FALSE;
    }
    
    // Private methods
    
    /**
     * Returns the currents script filename only. 
     * 
     * @return string
     */
    private function get_script_name() {
        $string = $_SERVER['SCRIPT_NAME'];
        $string = substr($string, strripos('/', $string));
        
        return $string;
    }
}