<?php
/**
 * Route 
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class Route {
    protected $uri;
    protected $regexp;
    protected $method;
    protected $callbacks = array();
    
    /**
     * Create a new route. 
     * 
     * @param string $uri 
     * @param string $method 
     * @param callback $callbacks
     */
    public function __construct($uri, $method, $callbacks) {
        // Array containing all the regular
        // expressions to search and replace for.
        $exp = array(
            '/:[a-zA-Z_][a-zA-Z0-9_]*/' => '[\w]+',
            '/\*/' => '.+'
        );
    
        // Check if there are multiple callback
        // defined and split them then into an array.
        if (is_string($callbacks) && strpos($callbacks, '|')) {
            $this->callbacks = explode('|', $callbacks);
        }
        else {
            $this->callbacks[] = $callbacks;
        }
        
        // Normalize the URI.
        $this->uri = '/'.trim($uri, '/');
        
        $this->method = $method;
        
        // Escape the forwardslashes.
        $this->regexp = str_replace('/', '\/', $uri);
        // Convert wild-cards to regular expressions.
        foreach ($exp as $key => $value) {
            $this->regexp = preg_replace($key, $value, $this->regexp);
        }
    }
    
    /**
     * Get the URI or, if set to TRUE, the regular expression.
     * 
     * @param mixed $regexp 
     * @return string
     */
    public function getUri($regexp = FALSE) {
        if ($regexp) {
            return $this->regexp;
        }
        return $this->url;
    }
    
    /**
     * Get the method. 
     * 
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }
    
    /**
     * Get all callbacks in an array. 
     * 
     * @return array
     */
    public function getCallbacks() {
        return $this->callback;
    }
}
