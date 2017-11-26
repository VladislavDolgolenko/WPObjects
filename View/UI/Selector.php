<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\View\UI;

class Selector extends AbstractUI
{
    protected $name = null;
    protected $lable = null;
    protected $options = array();
    protected $selected = array();
    protected $multibple = false;
    protected $desctiption = '';
    protected $array_result = false;
    protected $vertical = false;
    protected $has_image = false;
    protected $add_new_link = '';
    
    public function enqueues()
    {
        
    }

    public function setName($string)
    {
        $this->name = $string;
        
        return $this;
    }
    
    public function setLable($text)
    {
        $this->lable = $text;
        
        return $this;
    }
    
    public function setOptions($options)
    {
        $this->options = $options;
        
        $option = current($options);
        if (isset($option['img']) && $option['img'] || 
            isset($option['font-awesome']) && $option['font-awesome']) {
            $this->setHasImage(true);
        } 
        
        return $this;
    }
    
    public function setSelected($array)
    {
        if (!is_array($array)) {
            $array = array($array);
        }
        
        $this->selected = $array;
        
        return $this;
    }
    
    public function setMultiple($bollean)
    {
        $this->multibple = $bollean;
        if ($bollean) {
            $this->setArrayResult(true);
        }        
        
        return $this;
    }
    
    public function getDescription($text)
    {
        $this->desctiption = $text;
        
        return $this;
    }
    
    public function setArrayResult($bollean)
    {
        $this->array_result = $bollean;
        
        return $this;
    }
    
    public function setHasImage($bollean)
    {
        $this->has_image = $bollean;
        
        return $this;
    }
    
    public function setAddNewLink($link)
    {
        $this->add_new_link = $link;
        
        return $this;
    }
    
}