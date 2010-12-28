<?php
/**
 * Autoloader 
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class Autoloader {
    /**
     * core_loader 
     * 
     * @param mixed $class 
     * @return void
     */
    private static function core_loader($class) {
        $file = sprintf(BASE_PATH.'/core/%s.php', $class);
        
        if(!file_exists($file)) {
            return FALSE;
        }
        
        require_once($file);
        
        return TRUE;
    }
    
    /**
     * twig_loader 
     * 
     * @param mixed $class 
     * @return void
     */
    private static function twig_loader($class) {
        if (0 !== strpos($class, 'Twig')) {
            return FALSE;
        }
        
        $file = BASE_PATH.'/lib/'.str_replace('_', '/', $class).'.php';
        
        include_once($file);

        return TRUE;
    }
    
    /**
     *  
     */
    public static function register() {			
        spl_autoload_register(NULL, FALSE);
        spl_autoload_extensions('.php');
        spl_autoload_register('Autoloader::core_loader');
        spl_autoload_register('Autoloader::twig_loader');
    }
}
