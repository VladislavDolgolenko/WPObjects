<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Loader;

class NamespaceAutoloader
{
    protected $namespacesMap = array();
    
    public function __construct($options = null)
    {
        if ($options && count($options)) {
            $this->addNamespaces($options);
        }
    }
 
    public function addNamespaces($options)
    {
        foreach ($options as $namespace => $rootDir) {
            $this->addNamespace($namespace, $rootDir);
        }
    }
    
    public function addNamespace($namespace, $rootDir)
    {
        if (is_dir($rootDir)) {
            $this->namespacesMap[$namespace] = $rootDir;
            return true;
        }
        
        return false;
    }
    
    public function register()
    {
        spl_autoload_register(array($this, 'autoload'));
    }
    
    protected function autoload($class)
    {
        $pathParts = explode('\\', $class);
        
        if (is_array($pathParts)) {
            $namespace = array_shift($pathParts);
            
            if (!empty($this->namespacesMap[$namespace])) {
                $filePath = $this->namespacesMap[$namespace] . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $pathParts) . '.php';
                if (file_exists($filePath)) {
                    require_once $filePath;
                    return true;
                }
            }
        }
        
        return false;
    }
}