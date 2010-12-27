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
    
    public function getTwig() {
        
        if (isset(self::$objects['twig'])) {
            return self::$objects['twig'];
        }
        
        $settings = $this->getSettings();
        
        $loader = new Twig_Loader_Filesystem($settings['tmp_dir']);
        return self::$objects['twig'] = new Twig_Environment($loader, array(
          'cache' => $settings['cache_dir'],
          'auto_reload' => !$settings['cache']
        ));
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