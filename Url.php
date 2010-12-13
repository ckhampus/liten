<?php
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
     */
    public function __construct($url = NULL) {
        if(is_null($url)) {
            $url = get_current_url();
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
            $this->query = new Query();
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
     * @return string
     */
    public function getQueryString()
    {
        return $this->query;
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