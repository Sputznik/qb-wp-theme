<?php

/**
 * ABSTRACT MODEL THAT HANDLES SINGULAR DESIGN PATTERN
 */
class FII_BASE {

	private static $instance = null;

	public static function getInstance(){

		if( self::$instance == null ){
			self::$instance = array();
		}

		$class = get_called_class();

		if( !isset( self::$instance[ $class ] ) ){
      self::$instance[ $class ] = new static();
    }

    return self::$instance[ $class ];

	}

}