<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Factory;

abstract class AbstractPostFactory extends AbstractFactory
{
    protected $query = array();
    
    protected $meta_query = array();
    
    protected $filters = array();
    
    protected $context_models_methods = array();
    
    /**
     * @param $id string || integer || array
     * @return \MSP\Model\AbstractModel || null
     */
    public function get($id = null, $filters = array(), $single = true)
    {
        global $post;
        
        if ($id && $id instanceof \WP_Post) {
            $id = $id->ID;
        }
        
        $this->query(array_merge(array('id' => $id ? $id : $post->ID), $filters));
        
        if ($single) {
            return current($this->getResult());
        } else {
            return $this->getResult();
        }
    }
    
    protected function initModel($post)
    {
        $class = $this->getModelType()->getModelClassName();
        return new $class($post, $this->getModelType());
    }


    /**
     * Return array with compatible elements for autocompele selector in Visual Composer Addons.
     * @return array
     */
    function getForVCAutocompele()
    {
        /* @var $Object WPObjects\Model\AbstractModel */
        
        $result = array();
        foreach ($this->getResult() as $Object) {

            $result[] = array(
                'label' => $Object->post_title,
                'value' => $Object->ID,
            );
        }

        return $result;
    }
    
    /**
     * Build, send query and set results.
     * If result_as_object is true, result will be instance of \WP_Query
     * @return \MSP\Model\AbstractModel
     */
    public function query($filters = array(), $result_as_object = false)
    {
        $this->result = null;
        $this->filters = $filters;
        $this->result_as_object = $result_as_object;
        
        $this->readContext()
             ->buildQuery()
             ->buildPagination()
             ->buildOrdering()
             ->buildMetaQuery()
             ->sendQuery();
        
        return $this;
    }
    
    protected function readContext()
    {
        global $post;
        
        if (!isset($this->filters['page_context'])) {
            return $this;
        }
        
        if (get_post_type($post->ID) === $this->getModelType()) {
            $this->filters['id'] = $post->ID;
            return $this;
        }
        
        foreach ($this->getContextTypes() as $type) {
            if (get_post_type($post->ID) == $type) {
                $this->setIdsFromContext($post, $type);
                return $this;
            }
        }
        
        return $this;
    }
    
    protected function setIdsFromContext($post, $type)
    {
        $attr = $this->getSpecializationAttrName($type);
        if (!isset($this->context_models_methods[$type])) {
            $this->filters[$attr] = $post->ID;
        } else {
            $method = $this->context_models_methods[$type];
            $ids = $this->$method($post);
            $this->filters['post__in'] = $ids;
        }
        
        return $this;
    }
    
    protected function buildQuery()
    {
        $this->query = array();
        $this->meta_query = array('relation' => 'AND');
        $this->query = array(
            'post_type' => $this->getModelType(),
            'post_status' => 'publish',
            'meta_query' => &$this->meta_query,
            'numberposts' => -1
        );
        
        if (isset($this->filters['numberposts'])) {
            $this->query['numberposts'] = (int)$this->filters['numberposts'];
        }
        
        if (isset($this->filters['id']) && $this->filters['id']) {
            $this->query['post__in'] = $this->prepareMetaValue($this->filters['id']);
            $this->query['orderby'] = 'post__in';
        }
        
        if (isset($this->filters['_thumbnail_id']) && $this->filters['_thumbnail_id']) {
            $this->meta_query[] = array(
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS'
            );
        }
        
        return $this;
    }
    
    protected function buildPagination()
    {
        if (isset($this->filters['posts_per_page'])) {
            $this->query['posts_per_page'] = $this->filters['posts_per_page'];
        }
        
        if (isset($this->filters['page']) && $this->filters['page'] > 1) {
            $this->query['offset'] = $this->query['posts_per_page'] * ($this->filters['page'] - 1);
        }
        
        return $this;
    }
    
    protected function buildOrdering()
    {
        if (!isset($this->filters['orderby']) || !$this->filters['orderby']) {
            $this->buildDefaultOrgering();
            return $this;
        }
        
        $orderby = $this->filters['orderby'];
        if (strripos('_', $orderby) == 0) {
            $this->query['meta_key'] = $orderby;
            $this->query['orderby'] = 'meta_value_num';
        } else {
            $this->query['orderby'] = $orderby;
        }

        $this->query['order'] = isset($this->filters['order']) ? $this->filters['order'] : 'DESC';
        
        return $this;
    }
    
    protected function buildDefaultOrgering()
    {
        return;
    }
    
    protected function buildMetaQuery()
    {
        foreach ($this->relative_models_types as $type) {
            $attr = $this->getSpecializationAttrName($type);
            if (!isset($this->filters[$attr]) || !$this->filters[$attr]) {
                continue;
            }
            
            $this->meta_query[] = array(
                'key' => $attr,
                'value' => $this->prepareMetaValue($this->filters[$attr])
            );
        }
        
        $this->buildSpecialMetaQuery();
        
        return $this;
    }
    
    protected function buildSpecialMetaQuery()
    {
        return;
    }
    
    protected function sendQuery()
    {
        if ($this->result_as_object) {
            $result = new \WP_Query($this->query);
        } else {
            $result = \get_posts($this->query);
        }
        
        $this->initResults($result);
        return $this;
    }
    
    protected function initResults($result)
    {
        $models_result = array();
        if ($result instanceof \WP_Query) {
            $posts = $result->posts;
            $result->posts = &$models_result;
        } else {
            $posts = $result;
            $result = &$models_result;
        }
        
        foreach ($posts as $post) {
            $models_result[] = $this->initModel($post);
        }
        
        $this->setResult($result);
        
        return $this;
    }
    
    
    
}
