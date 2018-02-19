<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\PostType\MetaBox;

class Gallery extends \WPObjects\PostType\MetaBox\AbstractMetaBox
{
    public function __construct()
    {
        $this->setId('gallery');
        $this->setTitle('Gallery');
        $this->setPosition('normal');
        $this->setPriority('default');
        
        $template_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'templates';
        $this->setTemplatePath($template_dir . DIRECTORY_SEPARATOR . 'gallery.php');
    }
    
    public function processing(\WPObjects\Model\AbstractPostModel $Post, $data)
    {
        return $data;
    }
    
    public function enqueues()
    {
        parent::enqueues();
        $this->getAssetsManager()->enqueueScript('metabox_gallery');
    }
}