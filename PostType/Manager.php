<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\PostType;

class Manager implements \WPObjects\EventManager\ListenerInterface
{
    /**
     * @var \WPObjects\PostType\PostTypeFactory
     */
    protected $Factory = null;
    
    /**
     * @param \WPObjects\PostType\PostTypeFactory $Factory 
     */
    public function __construct(\WPObjects\PostType\PostTypeFactory $Factory)
    {
        $this->Factory = $Factory;
    }
    
    /**
     * Attach all post-types
     * @return $this
     */
    public function attach()
    {
        foreach ($this->getAll() as $PostType) {
            $PostType->attach();
        }
        
        return $this;
    }
    
    /**
     * Detach all post-types
     * @return $this
     */
    public function detach()
    {
        foreach ($this->getAll() as $PostType) {
            $PostType->detach();
        }
        
        return $this;
    }
    
    /**
     * @return \WPObjects\PostType\PostType
     */
    public function get($id)
    {
        return $this->getFactory()->get($id);
    }
    
    /**
     * @return \WPObjects\PostType\PostType
     */
    public function getAll()
    {
        return $this->getFactory()->query()->getResult();
    }
    
    /**
     * @return \WPObjects\PostType\PostTypeFactory
     */
    public function getFactory()
    {
        return $this->Factory;
    }
    
}