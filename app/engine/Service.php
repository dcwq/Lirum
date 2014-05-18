<?php 
namespace Engine;

use Engine\Exception\PrettyExceptions;

abstract class Service
{
    public static function getService($name)
    {
    	$className = "Services\\{$name}";
		
        if ( ! class_exists($className)) {
            throw new \Exception("Class {$className} doesn't exists.");
        }
        
        return new $className();
    }
}
