<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\View\UI;

class Checkbox extends AbstractUI
{
    protected $invert_with = null;
    protected $balance_with = null;
    protected $value = '';
    protected $type = 'text';
    
    public function __construct()
    {
        $template_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'template';
        $this->setTemplatePath($template_dir . DIRECTORY_SEPARATOR . 'checkbox.php');
    }
    
    public function setValue($string)
    {
        $this->value = $string;
        
        return $this;
    }
    
}