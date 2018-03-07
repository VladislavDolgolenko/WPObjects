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

namespace WPObjects\PostType\MetaBox;

class Location extends AbstractMetaBox
{
    public function __construct()
    {
        $this->setId('location');
        $this->setTitle(esc_html__('Location', 'msp'));
        $this->setPosition('normal');
        $this->setPriority('default');
        
        $template_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'templates';
        $this->setTemplatePath($template_dir . DIRECTORY_SEPARATOR . 'location.php');
    }
    
    public function enqueues()
    {
        parent::enqueues();
        
        $this->getAssetsManager()->enqueueScript('location-picker');
        $this->getAssetsManager()->enqueueStyle('bootstrap-wrapper');
    }
    
    public function processing(\WPObjects\Model\AbstractPostModel $Post, $data)
    {
        return $data;
    }
}