<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
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