<?php
spl_autoload_register(function($class){
    $file = "{$class}.php";
    
    require_once($file);
}); 

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
        // Initialize the Core.
        $core = new Core(array(
             // General application settings.
            'base_url'              => 'http://localhost',
            'cache'                 => FALSE,
            // File extension settings
            'file_extension'        => '.html',
            'use_file_extensions'   => TRUE,
            // Directory settings
            'cache_dir'             => './cache',
            'include_dir'           => './includes',
            'css_dir'               => './css',
            'js_dir'                => './js',
            'view_dir'              => './views'
        ));
        
        $this->settings = $core->getSettings();
        $this->routes = $core->getRouteCollection();
        $this->router = $core->getRouter();
    }

    private static function init() {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    // Properties
    
    private $settings = NULL;
    private $routes = NULL;
    private $router = NULL;
    private $http_status_codes = array(
        // 1xx (Provisional response)
        //
        // Status codes that indicate a provisional response
        // and require the requestor to take action to continue.
        '100' => 'Continue',
        '101' => 'Switching Protocols',
        // 2xx (Successful)
        //
        // Status codes that indicate that the
        // server successfully processed the request.
        '200' => 'OK',
        '201' => 'Created',
        '202' => 'Accepted',
        '203' => 'Non-Authoritative Information',
        '204' => 'No Content',
        '205' => 'Reset Content',
        '206' => 'Partial Content',
        // 3xx (Redirected)
        //
        // Further action is needed to fulfill the request.
        // Often, these status codes are used for redirection.
        '300' => 'Multiple Choices',
        '301' => 'Moved Permanently',
        '302' => 'Found',
        '303' => 'See Other',
        '304' => 'Not Modified',
        '305' => 'Use Proxy',
        '307' => 'Temporary Redirect',
        // 4xx (Request error)
        //
        // These status codes indicate that there was
        // likely an error in the request which prevented
        // the server from being able to process it.
        '400' => 'Bad Request',
        '401' => 'Unauthorized',
        '403' => 'Forbidden',
        '404' => 'Not Found',
        '405' => 'Method Not Allowed',
        '406' => 'Not Acceptable',
        '407' => 'Proxy Authentication Required',
        '408' => 'Request Timeout',
        '409' => 'Conflict',
        '410' => 'Gone',
        '411' => 'Length Required',
        '412' => 'Precondition Failed',
        '413' => 'Request Entity Too Large',
        '414' => 'Request-URI Too Long',
        '415' => 'Unsupported Media Type',
        '416' => 'Requested Range Not Satisfiable',
        '417' => 'Expectation Failed',
        // 5xx (Server error)
        //
        // These status codes indicate that the
        // server had an internal error when
        // trying to process the request.
        '500' => 'Internal Server Error',
        '501' => 'Not Implemented',
        '502' => 'Bad Gateway',
        '503' => 'Service Unavailable',
        '504' => 'Gateway Timeout',
        '505' => 'HTTP Version Not Supported'
    );
    
    // Methods
    
    /**
     * Associate a GET request
     * with a callback and a relative URL.
     *
     * @param string $route
     * @param callback $callbacks
     */
    public static function get($route, $callbacks) {
        self::init()->routes[] = new Route($route, 'GET', $callbacks);
    }

    /**
     * Associate a POST request
     * with a callback and a relative URL.
     *
     * @param string $route
     * @param callback $callbacks
     */
    public static function post($route, $callbacks) {
        self::init()->routes[] = new Route($route, 'POST', $callbacks);
    }

    /**
     * Associate a PUT request
     * with a callback and a relative URL.
     *
     * @param string $route
     * @param callback $callbacks
     */
    public static function put($route, $callbacks) {
        self::init()->routes[] = new Route($route, 'PUT', $callbacks);
    }

    /**
     * Associate a DELETE request
     * with a callback and a relative URL.
     *
     * @param string $route
     * @param callback $callbacks
     */
    public static function delete($route, $callbacks) {
        self::init()->routes[] = new Route($route, 'DELETE', $callbacks);
    }
    
    /**
     * run 
     * 
     * @return void
     */
    public static function run() {
        ob_start();
        
        if (!self::init()->router->execute()) {
            //self::response('404');
        }
        
        $output = ob_get_clean();
        
        /*
        $html = new DOMDocument();
        $html->loadHtml($output);
        
        $xpath = new DOMXPath($html);
        
        $result = $xpath->query('//title')->item(0);
        
        if (empty($result->nodeValue)) {
            $result->nodeValue = 'Liten Framework';
        }
        
        $output = $html->saveHtml();
        */
        
        echo $output;
    }
    
    /**
     * Get and set application settings.
     *
     * @param string|array $key
     * @param mixed $value
     * @return bool|string
     */
    public static function config($key = NULL, $value = NULL) {
        $liten = self::init();
        
        if (is_null($key) && is_null($value)) {
            return $liten->settings;
        }
        
        if (is_null($value)) {
            if (is_array($key)) {
                foreach ($key as $key => $value) {
                    if (array_key_exists($key, $liten->settings)) {
                        $liten->settings[$key] = $value;
                    }
                }

                return TRUE;
            }
        
            if (isset($liten->settings[$key])) {
                return $liten->settings[$key];
            }
        }
        
        if (isset($liten->settings[$key])) {
            $liten->settings[$key] = $value;
            return TRUE;
        }
        
        return FALSE;
    }
    
    public static function render($view, $data = NULL) {
        $liten = self::init();
        
        $liten->temp = array();
        $liten->temp['view'] = $view;
        $liten->temp['data'] = $data;
        unset($view, $data);
    
        if (strpos($liten->temp['view'], '.php') === FALSE) {
            $liten->temp['view'] .= '.php';
        }
        
        if (is_array($liten->temp['data'])) {
            extract($liten->temp['data']);
        }
        
        include_once($liten->settings['view_dir'].DIRECTORY_SEPARATOR.$liten->temp['view']);
        
        unset($liten->temp);
    }
    
    /**
     * Sends the header with th specified HTTP status code.
     *
     * @param int $status
     */
    public static function response($status) {
        $liten = self::init();

        if(array_key_exists($status, $liten->http_status_codes)) {
            if (!headers_sent()) {
                header('HTTP/1.1 '.$status.' '.$liten->http_status_codes[$status]);
            }
        }
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
    function stylesheet_url() {
        $url = 'http';
        $url .= '://'.Liten::config('base_url');
        $url .= $_SERVER['REQUEST_URI'];
        
        return $url;
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