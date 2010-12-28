<?php

/**
 * Core 
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class Core {
    protected static $objects = array();
    protected $parameters = array();
    
    /**
     * __construct 
     * 
     * @param array $parameters 
     * @return void
     */
    public function __construct(array $parameters = NULL) {
        if (!is_null($parameters)) {
            $this->parameters = $parameters;
        }
    }
    
    /**
     * Return the Settings object. 
     * 
     * @return Settings
     */
    public function getSettings() {
        if (isset(self::$objects['settings'])) {
            return self::$objects['settings'];
        }
        
        return self::$objects['settings'] = new Settings($this->parameters); 
    }
    
    /**
     * Return the RouteCollection object. 
     * 
     * @return RouteCollection
     */
    public function getRouteCollection() {
        if (isset(self::$objects['routes'])) {
            return self::$objects['routes'];
        }
        
        return self::$objects['routes'] = new RouteCollection(); 
    }
    
    /**
     * Return the Router object.
     * 
     * @return Router
     */
    public function getRouter() {
        if (isset(self::$objects['router'])) {
            return self::$objects['router'];
        }
        
        return self::$objects['router'] = new Router($this->getRouteCollection(), $this->getSettings());
    }
    
    /**
     * Return the Twig object.
     * 
     * @return Twig
     */
    public function getTwig() {
        
        if (isset(self::$objects['twig'])) {
            return self::$objects['twig'];
        }
        
        return self::$objects['twig'] = new Twig($this->getSettings());
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
        $string = substr($string, strripos($string, '/')+1);
        
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

if(!function_exists('stylesheet_url')) {
    function stylesheet_url($filename) {
        $url = Liten::config('base_url');
        $url .= Liten::config('css_dir');
        $url .= '/'.$filename;
        
        echo $url;
    }
}

if(!function_exists('javascript_url')) {
    function javascript_url($filename) {
        $url = Liten::config('base_url');
        $url .= Liten::config('js_dir');
        $url .= '/'.$filename;
        
        echo $url;
    }
}

/**
 * Get the current URL. 
 * 
 * @return string
 */
if(!function_exists('get_script_url')) {
    function get_script_url() {
        $url = 'http';

        if (isset($_SERVER['HTTPS'])) {
            $url .= 's';
        }
        
        $url .= '://'.$_SERVER['SERVER_NAME'];
        $url .= $_SERVER['SCRIPT_NAME'];
        
        return $url;
    }
}

/**
 * Get the current URL. 
 * 
 * @return string
 */
if(!function_exists('get_script_path')) {
    function get_script_path() {
        $url = get_script_url();
        $url = str_replace(get_script_name(), '', $url);
        $url = trim($url, '/');
        
        return $url;
    }
}
