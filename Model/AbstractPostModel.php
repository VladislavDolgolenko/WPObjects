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
    
    protected $register_metas = array();
    
    protected $metas = array();
    
    protected $defaults_attrs = array(
        'post_author',
        'post_date',
        'post_date_gmt',
        'post_content',
        'post_title',
        'post_excerpt',
        'post_status',
        'comment_status',
        'ping_status',
        'post_password',
        'post_name',
        'to_ping',
        'pinged',
        'guid',
        'menu_order',
        'post_type',
        'post_mime_type',
        'comment_count'
    );

    public function __construct($data)
    {
        $this->initFromPost($data);
    }
    
    protected function initFromPost(\WP_Post $post)
    {
        $this->post = $post;
        $register_atts = $this->getDefaultAttrs();
        foreach (\get_object_vars($post) as $key => $value) {
            if (count($register_atts) && !in_array($key, $register_atts)) {
                continue;
            }
            $this->$key = $value;
        }
        
        return $this;
    }
    
    public function save()
    {
        if (isset($this->ID)) {
            wp_update_post( $this->exchangeToPostArray() );
        } else {
            wp_insert_post( $this->exchangeToPostArray() );
        }
        
        $this->saveMetas();
        
        return $this;
    }
    
    public function saveMetas()
    {
        foreach ($this->getRegisterMetas() as $meta_name) {
            $this->saveMeta($key, $value);
        }
        
        return $this;
    }
    
    protected function saveMeta($key, $value)
    {
        if (is_array($value) && !is_array(current($value)) && is_int(key($value))) {
            \delete_post_meta($key);
            foreach ($value as $value) {
                \add_post_meta($this->getId(), $key, $value);
            }
        } else {
            \update_post_meta($this->getId(), $key, $value);
        }
        
        return $this;
    }
    
    public function exchangeToPostArray()
    {
        $result = array();
        $register_atts = $this->getDefaultAttrs();
        foreach (\get_object_vars($this) as $key => $value) {
            if (!in_array($key, $register_atts)) {
                continue;
            }
            
            $result[$key] = $value;
        }
        
        return $result;
    }
    
    /**
     * @return \WP_Post
     */
    public function getPost()
    {
        return $this->post;
    }
    
    public function getId()
    {
        return $this->ID;
    }
    
    public function getName()
    {
        return $this->getTitle();
    }
    
    public function getTitle()
    {
        return \get_the_title($this->ID);
    }
    
    // ПРИ ИНИЦИЛИЗАЦИИ ВЫТЯГИВАЕМ ВСЕ МЕТА ДАННЫЕ!!!!
    public function getMeta($key, $single = true)
    {
        $result = array();
        foreach ($this->metas as $meta) {
            if ($meta['key'] == $key) {
                $result[] = $meta['value'];
            }
        }
        
        if ($single) {
            return current($result) ? current($result) : null;
        } else {
            return $result;
        }
    }
    
    public function setMeta($key, $value)
    {
        if (!in_array($key, $this->getRegisterMetas())) {
            return $this;
        }
        
        if ($this->getMeta($key) == $value) {
            return $this;
        }
        
        $this->metas[] = array(
            'key' => $key,
            'value' => $value
        );
        
        return $this;
    }
    
    public function getRegisterAttrs()
    {
        array_merge($this->getRegisterMetas(), $this->getDefaultAttrs());
    }
    
    public function getDefaultAttrs()
    {
        return $this->defaults_attrs;
    }
    
    public function getRegisterMetas()
    {
        return $this->register_metas;
    }
}