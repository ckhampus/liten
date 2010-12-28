<?php

/**
 * Twig 
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class Twig {
    private $settings = NULL;
    private $template = NULL;
    private $twig     = NULL;
    
    /**
     * __construct 
     * 
     * @param Settings $settings 
     * @return void
     */
    public function __construct(Settings $settings) {
        $this->settings = $settings;
        
        $loader = new Twig_Loader_Filesystem($this->settings['tmp_dir']);
        
        $this->twig = new Twig_Environment($loader, array(
          'cache' => $this->settings['cache_dir'],
          'auto_reload' => !$this->settings['cache']
        ));
    }
    
    /**
     * loadTemplate 
     * 
     * @param mixed $template 
     * @return void
     */
    public function loadTemplate($template) {
        $this->template = $this->twig->loadTemplate($template);
    }
    
    /**
     * display 
     * 
     * @param mixed $data 
     * @return void
     */
    public function display($data) {
        $this->template->display($data);
    }
}
