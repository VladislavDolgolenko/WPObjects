<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Service;

class DI implements ManagerInterface
{
    protected $ServiceManager = null;
    
    /**
     * Config structure:
     *      array(
     *          target_class_name => array (
     *              dependeciend_service_name => setter_method_name
     *          )
     *          ...
     *      );
     * where target_class_name - with out root separator "\"
     * @var array
     */
    protected $config = array();
    
    public function inject($Object)
    {
        $class_name = get_class($Object);
        if (strpos('\\', $class_name) === 0) {
            $class_name = substr($class_name, 1);
        }
        
        if (!isset($this->config[$class_name])) {
            return $Object;
        }
        
        $deps = $this->config[$class_name];
        foreach ($deps as $service_name => $setter_mathod) {
            $Service = $this->getServiceManager()->get($service_name);
            if (!$Service) {
                throw new \Exception("Undefined service $service_name for $class_name.");
            }
            $Object->$setter_mathod($Service);
        }
        
        return $Object;
    }
    
    public function addConfig($config)
    {
        $this->config = array_merge($this->config, $config);
    }
    
    public function setConfig($config)
    {
        $this->config = $config;
    }
    
    public function setServiceManager(\WPObjects\Service\Manager $ServiceManager)
    {
        $this->ServiceManager = $ServiceManager;
    }
    
    public function getServiceManager()
    {
        return $this->ServiceManager;
    }
}