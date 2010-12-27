<?php
class Autoloader {
    private static function core_loader($class) {
        $file = sprintf(__DIR__.'/%s.php', $class);
        
        //var_dump($file, file_exists($file));
        
        if(!file_exists($file)) {
            return FALSE;
        }
        
        require_once($file);
    }
    
    private static function twig_loader($class)
    {
        if (0 !== strpos($class, 'Twig')) {
            return FALSE;
        }
        
        $file = __DIR__.'/lib/'.str_replace('_', '/', $class).'.php';
        
        include_once($file);

        return TRUE;
    }
    
    public static function register() {			
        spl_autoload_register(NULL, FALSE);
        spl_autoload_extensions('.php');
        spl_autoload_register('Autoloader::core_loader');
        spl_autoload_register('Autoloader::twig_loader');
    }
}