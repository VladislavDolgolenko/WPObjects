<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\PostType;

use WPObjects\Model\AbstractModel;

abstract class MetaBox extends AbstractModel
{
    protected $id = null;
    protected $title = null;
    protected $position = null;
    protected $priotity = null;
    
    /**
     * @var \WP_Post
     */
    protected $Post = null;
    
    /**
     * @return array
     */
    abstract public function processing(\WPObjects\Model\AbstractPostModel $Post, $data);
    
    /**
     * @param \WP_Post $post
     * @return $this
     */
    public function render(\WP_Post $post)
    {
        $this->Post = $post;
        
        $template_path = $this->getTemplatePath();
        if (!\file_exists($template_path)) {
            return;
        }
        
        $this->enqueues();
        include($template_path);
        
        return $this;
    }

    abstract protected function enqueues();
    
    abstract protected function getTemplatePath();
    
    public function getPost()
    {
        return $this->Post;
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

