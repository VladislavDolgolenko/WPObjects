<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\LessCompiler;

class ParamModel extends \ArrayObject implements
    \WPObjects\Service\NamespaceInterface,
    \WPObjects\Model\ModelInterface
{
    protected $namespace = '';
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->label ? $this->label : $this->id;
    }
    
    public function exchange($data)
    {
        $this->exchangeArray($data);
        
        return $this;
    }
    
    public function getCurrentValue()
    {
        $setting_name = $this->getSettingName();
        return \get_theme_mod($setting_name, $this->default);
    }
    
    public function getSettingName()
    {
        return $this->getNamespace() . $this->id;
    }
    
    public function setNamespace($string)
    {
        $this->namespace = $string;
        
        return $this;
    }
    
    public function getNamespace()
    {
        return $this->namespace;
    }
}