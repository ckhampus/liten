<?php

class Core {
    protected static $objects = array();
    protected $parameters = array();
    
    public function __construct(array $parameters = NULL) {
        if (!is_null($parameters)) {
            $this->parameters = $parameters;
        }
    }
    
    public function getSettings() {
        if (isset(self::$objects['settings'])) {
            return self::$objects['settings'];
        }
        
        return self::$objects['settings'] = new Settings($this->parameters); 
    }
    
    public function getRouteCollection() {
        if (isset(self::$objects['routes'])) {
            return self::$objects['routes'];
        }
        
        return self::$objects['routes'] = new RouteCollection(); 
    }
    
    public function getRouter() {
        if (isset(self::$objects['router'])) {
            return self::$objects['router'];
        }
        
        return self::$objects['router'] = new Router($this->getRouteCollection(), $this->getSettings());
    }
}