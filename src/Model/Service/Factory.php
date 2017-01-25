<?php
namespace Sensibilis\Model\Service;

class Factory extends \League\Container\Container{
	
	private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
                self::$instance = new Factory();
                
        }
        return self::$instance;
    }
	
    public static function register($serviceName, $serviceClass) {
        self::getInstance()->add($serviceName, $serviceClass);
    }

    public static function registerSingleton($serviceName, $serviceClass) {
        self::getInstance()->share($serviceName, $serviceClass);
    }

    public static function make($serviceName){
        return self::getInstance()->get($serviceName);
    }

}