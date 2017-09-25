<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

/**
 * This autoloader has dynamic namespaces definition for including classes.
 * Special from vladislavdolgolenko.com
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

    public function addNamespace($namespace, $rootDir, $dynamic_namespace = false)
    {
        if (is_dir($rootDir)) {
            $this->namespacesMap[$namespace] = array(
                'path' => $rootDir,
                'dynamic' => $dynamic_namespace ? true : false
            );
            return true;
        }

        return false;
    }

    public function register()
    {
        spl_autoload_register(array($this, 'autoload'));
    }

    public function initNamespaceByClass($class)
    {
        $pathParts = explode('\\', $class);
        $Namespace = null;
        $serach = $class;
        
        for ($i = 0; $i < count($pathParts); $i++) {
            $pos = strrpos($serach, '\\');
            if ($pos !== false) {
                $serach = substr($serach, 0, $pos);
            } 
            if (isset($this->namespacesMap[$serach])) {
                $Namespace = $this->namespacesMap[$serach];
                break;
            }
        }

        if (!$Namespace) {
            return false;
        }

        $class_file_path = str_replace($serach, $Namespace['path'], $class);
        $system_class_path = str_replace('\\', DIRECTORY_SEPARATOR, $class_file_path) . '.php';

        return new \ArrayObject(array(
            'namespace_path' => $Namespace['path'],
            'class_file_path' => $system_class_path, 
            'dynamic' => $Namespace['dynamic'],
            'main_namespace' => $serach
        ), \ArrayObject::ARRAY_AS_PROPS);
    }

    public function getClassNameSpace($class)
    {
        $parts = explode('\\', $class);
        array_pop($parts);
        $namespace = implode('\\', array_filter($parts));
        if ($namespace) {
            return $namespace;
        }

        return false;
    }

    public function getClassName($class)
    {
        $pathParts = explode('\\', $class);
        $class_name = array_pop($pathParts);
        if ($class_name) {
            return $class_name;
        }

        return false;
    }

    protected function autoload($class)
    {
        $Namespace = $this->initNamespaceByClass($class);
        $class_name = $this->getClassName($class);
        $class_namespace = $this->getClassNameSpace($class);

        if (!$class_name || !$Namespace) {
            return false;
        }
        
        if (file_exists($Namespace->class_file_path)) {

            if ($Namespace->dynamic && $class_namespace) {
                $code = file_get_contents($Namespace->class_file_path);
                $code = str_replace("WPObjects\\", $Namespace->main_namespace . "\\", $code);
                $code = "?>" . $code . '';
                eval($code);
            } else {
                include $Namespace->class_file_path;
            }

            return true;
        }

        return false;
    }
}