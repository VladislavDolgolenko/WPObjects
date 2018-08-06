<?php

/**
 * @encoding     UTF-8
 * @package      WPObjects
 * @link         https://github.com/VladislavDolgolenko/WPObjects
 * @copyright    Copyright (C) 2018 Vladislav Dolgolenko
 * @license      MIT License
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      <help@vladislavdolgolenko.com>
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
    
    public function getType()
    {
        return $this->get('type');
    }
    
    public function getOptions()
    {
        return $this->get('options');
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