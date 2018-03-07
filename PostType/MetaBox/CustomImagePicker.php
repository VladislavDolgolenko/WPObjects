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

class CustomImagePicker extends AbstractMetaBox
{
    public function __construct()
    {
        $this->setPosition('side');
        $this->setPriority('default');
        
        $template_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'templates';
        $this->setTemplatePath($template_dir . DIRECTORY_SEPARATOR . 'custom-image-picker.php');
        
        add_action('add_meta_boxes', array($this, 'deleteDefaultThumbnailBox'), 1000, 2);
    }
    
    public function enqueues()
    {
        parent::enqueues();
        
        $this->getAssetsManager()->enqueueScript('metabox_image_picker');
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
    
    public function processing(\WPObjects\Model\AbstractPostModel $Post, $data)
    {
        return $data;
    }
}