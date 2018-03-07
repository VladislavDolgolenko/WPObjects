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

namespace WPObjects\PostType\Listeners;

abstract class PostView implements
    \WPObjects\EventManager\ListenerInterface,
    \WPObjects\Service\ManagerInterface
{
    /**
     * @var \WPObjects\PostType\PostType
     */
    protected $PostType;
    
    /**
     * Global service manager
     * 
     * @var \WPobjects\Service\Manager
     */
    protected $ServiceManager = null;
    
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
    
    public function setServiceManager(\WPObjects\Service\Manager $ServiceManager)
    {
        $this->ServiceManager = $ServiceManager;
        
        return $this;
    }
    
    /**
     * @return \WPObjects\Service\Manager
     * @throws \Exception
     */
    public function getServiceManager()
    {
        if (is_null($this->ServiceManager)) {
            throw new \Exception('Undefined service manager');
        }
        
        return $this->ServiceManager;
    }
}