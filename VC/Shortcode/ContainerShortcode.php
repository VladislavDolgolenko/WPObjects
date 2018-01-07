<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\VC\Shortcode;

if (!class_exists('WPBakeryShortCodesContainer')) {
    return;
}

class ContainerShortcode extends \WPBakeryShortCodesContainer implements
    \WPObjects\VC\AddonInterface
{
    /**
     * @var \WPObjects\VC\CustomAddonModel
     */
    protected $Addon = null;
    
    public function __construct( $settings )
    {
        parent::__construct($settings);
        
        $this->setAddon($settings['AddonModel']);
    }
    
    public function enqueueDefaultScripts()
    {
        parent::enqueueDefaultScripts();
        
        $this->getAddon()->enqueues();
    }
    
    public function beforeShortcode($atts, $content)
    {
        parent::beforeShortcode($atts, $content);
        
        $this->getAddon()->beforeContent();
    }
    
    public function setAddon(\WPObjects\VC\CustomAddonModel $Addon)
    {
        $this->Addon = $Addon;
        
        return $this;
    }
    
    /**
     * @retrun \WPObjects\VC\CustomAddonModel
     */
    public function getAddon()
    {
        return $this->Addon;
    }
}