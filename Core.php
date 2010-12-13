<?php

class Core {
    private static $objects = array();
    
    public function getRouteCollection() {
        if(isset(self::$objects['routes'])) {
            return self::$objects['routes'];
        }
        
        return self::$objects['routes'] = new RouteCollection(); 
    }
    
    public function getRouter() {
        if(isset(self::$objects['router'])) {
            return self::$objects['router'];
        }
        
        return self::$objects['router'] = new Router($this->getRouteCollection());
    }
}