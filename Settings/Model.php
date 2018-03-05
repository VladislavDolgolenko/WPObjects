<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\Settings;

class Model extends \WPObjects\Settings\AbstractModel implements
    \WPObjects\Service\NamespaceInterface
{
    public function getCurrentValue()
    {
        return \get_option($this->getWPOptionKey(), $this->getDefault());
    }
    
    public function setCurrentValue($value)
    {
        if (is_null($value) || $value === "") {
            \delete_option($this->getWPOptionKey());
        } else {
            \update_option($this->getWPOptionKey(), $value);
        }
        
        return $this;
    }
    
    public function getWPOptionKey()
    {
        return $this->getNamespace() . '_setting_' . $this->getId();
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
    
    public function getViewUI()
    {
        if ($this->getType() === self::TYPE_TEXT) {
            
        }
    }
}