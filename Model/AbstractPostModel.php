<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Model;

abstract class AbstractPostModel extends AbstractModel
{
    /**
     * @var \WP_Post
     */
    protected $post = null;
    
    /**
     * @var \WPObjects\Model\AbstractModel in array
     */
    protected $relatives = array();
    
    public function __construct($data)
    {
        $this->initFromPost($data);
    }
    
    protected function initFromPost(\WP_Post $post)
    {
        $this->post = $post;
        foreach (\get_object_vars($post) as $key => $value) {
            $this->$key = $value;
        }
        
        return $this;
    }
    
    public function getTitle()
    {
        return \get_the_title($this->ID);
    }
    
    /**
     * 
     * @param string $key
     * @param boolean $single
     * @return array || string
     */
    public function getMeta($key, $single = true)
    {
        return get_post_meta($this->ID, $key, $single);
    }
    
    /**
     * @return \WP_Post
     */
    public function getPost()
    {
        return $this->post;
    }
}