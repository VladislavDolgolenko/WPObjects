<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\VC\Shortcode;

if (!class_exists('WPBakeryShortCode')) {
    return;
}

class DefaultShortcode extends \WPBakeryShortCode
{
    protected $Addon = null;
    
    public function __construct( $settings )
    {
        $this->Addon = $settings['CustomAddonModel'];
        parent::__construct( $settings );
    }
    
    public function enqueueDefaultScripts()
    {
        $this->Addon->enqueues();
        return parent::enqueueDefaultScripts();
    }
    
    public function beforeShortcode($atts, $content)
    {
        parent::beforeShortcode($atts, $content);
        $this->Addon->beforeShortcode();
    }
    
}