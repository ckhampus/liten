<?php
/**
 * RouteCollection 
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class RouteCollection implements Iterator, ArrayAccess {
    private $routes = array();
    private $position = 0;
    
    public function __construct() {
        $this->position = 0;
    }

    // Iterator

    public function current() {
        return $this->routes[$this->position];
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
    }

    public function rewind() {
        $this->position = 0;
    }

    public function valid() {
        return isset($this->routes[$this->position]);
    }

    // ArrayAccess

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->routes[] = $value;
        } else {
            $this->routes[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->routes[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->routes[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->routes[$offset]) ? $this->routes[$offset] : NULL;
    }

    // Other methods

    /**
     * Add a route to the collection. 
     * 
     * @param Route $route 
     */
    public function add(Route $route) {
        $this->routes[] = $route;
    }

}
