<?php
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
    protected $url;
    protected $method;
    
    /**
     * Creates a Request instance.
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