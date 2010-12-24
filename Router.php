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
    protected $routes = NULL;
    protected $settings = NULL;

    public function __construct(RouteCollection $routes, Settings $settings) {
        $this->routes = $routes;
        $this->settings = $settings;
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
        $base = new Url(get_script_url());
        
        // Remove script name and redundent slashes.
        $requested_path = str_replace('//', '/', str_replace(get_script_name(), '', $request->getUrl()->getPath()));
        $base_path = str_replace(get_script_name(), '', $base->getPath());
        
        $path = substr($requested_path, strlen($base_path) - 1);
                
        foreach($this->routes as $route) {
            // Get the values for the arguments by computing
            // the difference between the route and the actual uri.
            $arguments = array_diff(explode('/', $path), explode('/', $route->getUri()));
        
            // Check if the requested http method is the
            // same as the method specified in the route.
            if ($request->getMethod() === $route->getMethod()) {
            
                $GLOBALS['_PUT']  = array();
                if($route->getMethod() == 'PUT') {
                    parse_str(file_get_contents('php://input'), $GLOBALS['_PUT']);
                }
            
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