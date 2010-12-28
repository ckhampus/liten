<?php
define('BASE_PATH', __DIR__);

require_once('core/Autoloader.php');
Autoloader::register();

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
            'base_url'              => get_script_path(),
            'cache'                 => FALSE,
            // File extension settings
            'file_extension'        => '.html',
            'use_file_extensions'   => TRUE,
            // Directory settings
            'cache_dir'             => BASE_PATH.'/cache',
            'lib_dir'               => BASE_PATH.'/lib',
            'view_dir'              => BASE_PATH.'/views',
            'tmp_dir'               => BASE_PATH.'/templates',
            // Web directory settings
            'css_dir'               => '/css',
            'js_dir'                => '/js',
        ));
        
        $this->settings = $core->getSettings();
        $this->routes   = $core->getRouteCollection();
        $this->router   = $core->getRouter();
    }

    /**
     * init 
     * 
     * @return void
     */
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
    private $twig = NULL;
    private $core = NULL;
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
     * Start the framework.
     */
    public static function run() {        
        $core = new Core();
        self::init()->twig = $core->getTwig();
    
        if (!self::init()->router->execute()) {
            //self::response('404');
        }
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
    
    /**
     * Load the template to use. 
     * 
     * @param string $template
     */
    public static function loadTemplate($template) {
        self::init()->twig->loadTemplate($template);
    }
    
    /**
     * Renders the template file.
     * 
     * @param mixed $data 
     * @return void
     */
    public static function display($data) {
        $data['base_url'] = get_script_path();
    
        self::init()->twig->display($data);
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
