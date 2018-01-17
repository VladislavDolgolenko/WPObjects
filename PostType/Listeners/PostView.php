<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\PostType\Listeners;

abstract class PostView implements
    \WPObjects\EventManager\ListenerInterface
{
    /**
     * @var \WPObjects\PostType\PostType
     */
    protected $PostType;
    
    public function attach()
    {
        \add_action('wp', array($this, '_handler'));
    }
    
    public function detach()
    {
        \remove_action('wp', array($this, '_handler'));
    }
    
    public function _handler()
    {
        global $post;
        
        if (!is_singular() || 
            !$this->getPostType() ||
            !isset($post->post_type) ||
            $post->post_type !== $this->getPostType()->getId()
            ) {
            return;
        }
        
        $PostModel = $this->getPostType()->initModel($post);
        $this->processing($PostModel);
    }
    
    abstract function processing(\WPObjects\Model\AbstractPostModel $PostModel);
    
    public function setPostType(\WPObjects\PostType\PostType $PostType)
    {
        $this->PostType = $PostType;
    }
    
    public function getPostType()
    {
        return $this->PostType;
    }
}