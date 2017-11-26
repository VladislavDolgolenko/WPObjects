<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\View;

class View implements
    \WPObjects\View\ViewInterface
{
    protected $template_path = null;
    
    public function getTemplate()
    {
        return $this->template_path;
    }
    
    public function setTemplate($string)
    {
        $this->template_path = $string;
    }
    
    public function enqueues()
    {
        
    }
    
    public function render()
    {
        $this->enqueues();
        include $this->template_path;
    }
}