<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\PostType;

use WPObjects\View\View;

abstract class MetaBox extends View
{
    protected $id = null;
    protected $title = null;
    protected $position = null;
    protected $priotity = null;
    
    /**
     * @var \WP_Post
     */
    protected $Post = null;
    
    protected $box = null;
    
    /**
     * @return array
     */
    abstract public function processing(\WPObjects\Model\AbstractPostModel $Post, $data);
    
    /**
     * @param \WP_Post $post
     * @return $this
     */
    public function handler(\WP_Post $post, $box)
    {
        $this->Post = $post;
        $this->box = $box;
        
        $this->render();
    }

    public function getPost()
    {
        return $this->Post;
    }
    
    public function getBox()
    {
        return $this->box;
    }
    
    public function setId($int)
    {
        $this->id = $int;
        
        return $this;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->getTitle();
    }
    
    public function setTitle($string)
    {
        $this->title = $string;
        
        return $this;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setPosition($string)
    {
        $this->position = $string;
        
        return $this;
    }
    
    public function getPosition()
    {
        return $this->position;
    }
    
    public function setPriority($string)
    {
        $this->priotity = $string;
        
        return $this;
    }
    
    public function getPriority()
    {
        return $this->priotity;
    }
    
}

