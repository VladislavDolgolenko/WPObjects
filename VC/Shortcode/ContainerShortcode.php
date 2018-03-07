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