<?php
namespace App\Tools;

/**
 * Class Loader
 * @package App\Tools
 * 加载service实例
 */
class Loader {

    /**
     * @param $serviceName
     * @return mixed
     */
    public static function getService($serviceName) {
        $serviceList = [];
        if(!isset($serviceName[$serviceName])) {
            $serviceList[$serviceName] = new $serviceName;
        }
        return $serviceList[$serviceName];
    }
}
