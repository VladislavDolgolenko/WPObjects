<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace MSP\MetaBox;

class CustomImagePicker extends AbstractMetaBox
{
    public function __construct()
    {
        $this->setPosition('side');
        $this->setPriority('default');
        
        add_action('add_meta_boxes', array($this, 'deleteDefaultThumbnailBox'), 1000, 2);
    }
    
    public function deleteDefaultThumbnailBox($post_type, $post)
    {
        $this->Post = $post;
        $PostType = $this->getPostType();
        if (!$PostType) {
            return;
        }
        
        foreach ($PostType->getMetaBoxes() as $MetaBox) {
            if ($MetaBox === $this) {
                \remove_meta_box('postimagediv', $post_type, 'side');
            }
        }
    }
    
    public function processing(\MSP\WPObjects\Model\AbstractPostModel $Post, $data)
    {
        return $data;
    }
    
    public function getTemplatePath()
    {
        return MSP_PATH . 'includes/templates/meta-box/custom-image-picker.php';
    }
    
    public function enqueues() 
    {
        parent::enqueues();
        
        wp_enqueue_script('msp-image-picker');
    }
}