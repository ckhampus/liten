<?php

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
        $this->dispatcher = Dispatcher::instance();
    }

    private function init() {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }
    
    // Properties
    
    private $dispatcher;
    
    // Methods
    
    /**
     * Associate a GET request
     * with a callback and a relative URL.
     *
     * @param string $route
     * @param callback $callbacks
     */
    public static function get($route, $callbacks) {
        $dispatcher = self::init()->dispatcher;
        $dispatcher->addRoute($route, 'GET', $callbacks);
    }

    /**
     * Associate a POST request
     * with a callback and a relative URL.
     *
     * @param string $route
     * @param callback $callbacks
     */
    public static function post($route, $callbacks) {
        $dispatcher = self::init()->dispatcher;
        $dispatcher->addRoute($route, 'POST', $callbacks);
    }

    /**
     * Associate a PUT request
     * with a callback and a relative URL.
     *
     * @param string $route
     * @param callback $callbacks
     */
    public static function put($route, $callbacks) {
        $dispatcher = self::init()->dispatcher;
        $dispatcher->addRoute($route, 'PUT', $callbacks);
    }

    /**
     * Associate a DELETE request
     * with a callback and a relative URL.
     *
     * @param string $route
     * @param callback $callbacks
     */
    public static function delete($route, $callbacks) {
        $dispatcher = self::init()->dispatcher;
        $dispatcher->addRoute($route, 'DELETE', $callbacks);
    }
    
    /**
     * run 
     * 
     * @return void
     */
    public static function run() {
        $dispatcher = self::init()->dispatcher;
        $dispatcher->execute();
    }
}

/**
 * Dispatcher 
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class Dispatcher {
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
     * setRoute 
     * 
     * @param mixed $uri 
     * @param mixed $method 
     * @param mixed $callback 
     * @return void
     */
    public function addRoute($uri, $method, $callback) {
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
    
        $this->routes[] = array(
            'uri'       => $uri,
            'regexp'    => $regexp,
            'method'    => $method,
            'callbacks' => $callbacks
        );
    }
    
    /**
     * Executes the dispatcher. 
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
                        else {
                            throw new Exception('No valid callback defined.');
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
     * @return void
     */
    private function get_script_name() {
        $string = $_SERVER['SCRIPT_NAME'];
        $string = substr($string, strripos('/', $string));
        
        return $string;
    }
}

/**
 * Request 
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class Request {
    private $url;
    private $method;
    
    /**
     * __construct 
     * 
     * @return void
     */
    public function __construct() {
        $this->url = new Url();
        $this->method = $_SERVER['REQUEST_METHOD'];
    }
    
    /**
     * Gets the URL object from the current request. 
     * 
     * @return Url
     */
    public function getUrl() {
        return $this->url;
    }
    
    /**
     * Gets the HTTP method from the current request. 
     * 
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }
}

/**
 * Url 
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class Url {
    private $scheme;
    private $host;
    private $path;
    private $query;
    
    /**
     * Creates a new URL instance.
     * 
     * @param string $url 
     * @return void
     */
    public function __construct($url = NULL) {
        if(!isset($url)) {
            $url = $this->get_current_url();
        }
    
        if (!filter_var($url, FILTER_VALIDATE_URL, array(FILTER_FLAG_SCHEME_REQUIRED, FILTER_FLAG_HOST_REQUIRED))) {
            throw new UrlException('The specified URL is invalid.');
        }
        
        $url = parse_url($url);
        $this->scheme = $url['scheme'];
        $this->host = $url['host'];
        
        if (isset($url['path'])) {
            $this->path = $url['path'];
        }
        
        if (isset($url['query'])) {
            $this->query = $url['query'];
        }
    }
    
    /**
     * Get the scheme part of the URL.
     * 
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }
    
    /**
     * Get the host part of the URL.
     * 
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }
    
    /**
     * Get the path part of the URL.
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * Get the query string of the URL
     * 
     * @return void
     */
    public function getQueryString()
    {
        return $this->query;
    }
    
    /**
     * Get the current URL. 
     * 
     * @return string
     */
    protected function get_current_url() {
        $url = 'http';

        if (isset($_SERVER['HTTPS'])) {
            $url .= 's';
        }
        
        $url .= '://'.$_SERVER['SERVER_NAME'];
        $url .= $_SERVER['REQUEST_URI'];
        
        return $url;
    }
}

/**
 * UrlException 
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class UrlException extends Exception {}
