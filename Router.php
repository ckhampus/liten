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
    private $routes = NULL;

    public function __construct(RouteCollection $routes) {
        $this->routes = $routes;
    } 
    
    // Methods
    
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
        
        foreach($this->routes as $route) {
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
}