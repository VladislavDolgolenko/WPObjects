<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Model;

abstract class AbstractPostModel extends AbstractTypicalModel
{
    /**
     * WordPress post object of current object
     * @var \WP_Post
     */
    protected $post = null;
    
    /**
     * Initialize meta data of current object
     * @var array
     */
    protected $metas = array();

    protected function exchangeObject($post)
    {
        $this->post = $post;
        $register_atts = $this->getModelType()->getDefaultAttrs();
        foreach (\get_object_vars($post) as $key => $value) {
            if (count($register_atts) && !in_array($key, $register_atts)) {
                continue;
            }
            $this->$key = $value;
        }
        
        $all_metas = \get_post_meta($post->ID);
        foreach ($all_metas as $key => $value) {
            $this->setMeta($key, $value);
        }
        
        return $this;
    }
    
    public function save()
    {
        if (isset($this->ID)) {
            \wp_update_post( $this->exchangeToPostArray() );
        } else {
            $post_id = \wp_insert_post( $this->exchangeToPostArray() );
            $post = \get_post($post_id);
            $this->initFromPost($post);
        }
        
        $this->saveMetas();
        
        return $this;
    }
    
    public function saveMetas()
    {
        foreach ($this->getRegisterMetas() as $meta_name) {
            $value = $this->getMeta($meta_name);
            $this->saveMeta($meta_name, $value);
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
    
    public function getMeta($key)
    {
        if (!isset($this->metas[$key])) {
            return null;
        }
        
        $result = $this->metas[$key];
        return $result;
    }
    
    public function setMeta($key, $value)
    {
        if (is_array($value) && count($value) === 1) {
            $value = current($value);
        }
        
        if (!in_array($key, $this->getModelType()->getRegisterMetas())) {
            return $this;
        }
        
        if ($this->getMeta($key) == $value) {
            return $this;
        }
        
        $this->metas[$key] = $value;
        
        return $this;
    }
    
    /**
     * Get associated model identities
     * @param string $model_type_id
     */
    public function getQualifierId($model_type_id)
    {
        $attr_name = $this->getModelType()->getQualifierAttrName($model_type_id);
        return $this->getMeta($attr_name);
    }
    
    /**
     * Set association with other typical model instance 
     * @param string $model_type_id
     * @param int $model_id
     * @return $this
     */
    public function setQualifierId($model_type_id, $model_id)
    {
        $attr_name = $this->getModelType()->getQualifierAttrName($model_type_id);
        $this->setMeta($attr_name, $model_id);
        
        return $this;
    }
    
}
