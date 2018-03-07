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