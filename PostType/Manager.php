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