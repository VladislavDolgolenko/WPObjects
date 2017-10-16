<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Factory;

abstract class AbstractPostFactory extends AbstractModelFactory implements
    \WPObjects\Factory\TypicalModelFactoryInterface
{
    /**
     * Object ModelType of current factory objects
     * @var \WPObjects\Model\AbstractModelType
     */
    protected $ModelType = null;
    
    /**
     * Main query array for \WP_Query object
     * @var array
     */
    protected $query = array();
    
    /**
     * Meta query array for \WP_Query object.
     * At query preparation linked to $this->query['meta_query']
     * @var array
     */
    protected $meta_query = array();
    
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
    
    /**
     * Return array with compatible elements for autocompele selector in Visual Composer.
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
     * @param boolean $result_as_object Query flag. How to create result object. 
     * If true, result must be instance of \WP_Query
     * @return \MSP\Model\AbstractModel
     */
    public function query($filters = array(), $result_as_object = false)
    {
        $this->setFilters($filters);
        $this->result_as_object = $result_as_object;
        
        $this->buildQuery()
             ->buildPagination()
             ->buildOrdering()
             ->buildMetaQuery()
             ->sendQuery();
        
        return $this;
    }
    
    protected function buildQuery()
    {
        $this->query = array();
        $this->meta_query = array('relation' => 'AND');
        $this->query = array(
            'post_type' => $this->getModelType()->getId(),
            'post_status' => 'publish',
            'meta_query' => &$this->meta_query,
            'numberposts' => -1
        );
        
        if (isset($this->filters['numberposts'])) {
            $this->query['numberposts'] = (int)$this->filters['numberposts'];
        }
        
        if (isset($this->filters['id']) && $this->filters['id']) {
            $this->query['post__in'] = $this->prepareStringToArray($this->filters['id']);
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
        foreach ($this->getModelType()->getQualifiersAttrsNames() as $attr) {
            if (!isset($this->filters[$attr]) || !$this->filters[$attr]) {
                continue;
            }
            
            $this->meta_query[] = array(
                'key' => $attr,
                'value' => $this->prepareStringToArray($this->filters[$attr])
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
    
    protected function initModel($post)
    {
        return $this->getModelType()->initModel($post);
    }
    
    /**
    * @return \WPObjects\Model\AbstractModelType
    */
    public function getModelType()
    {
        if (is_null($this->ModelType)) {
            throw new \Exception('Undefiend model type!');
        }
        
        return $this->ModelType;
    }
    
    public function setModelType(\WPObjects\Model\AbstractModelType $ModelType)
    {
        $this->ModelType = $ModelType;
        
        return $this;
    }
    
}
