<?php
/**
 * Query 
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class Query {
    private $data = array();

    public function __construct() {
        $this->data = $_GET;
    }

    public function __get( $name ) {
        if ( array_key_exists( $name, $this->data ) ) {
            return $this->data;
        }
    }
}