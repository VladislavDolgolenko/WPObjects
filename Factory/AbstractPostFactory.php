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
    
    /**
     * @param $id string || integer || array
     * @return \MSP\Model\AbstractModel || null
     */
    public function get($id)
    {
        $this->query(array('id' => $id));
        return count($this->getResult()) > 1 ? $this->getResult() : current($this->getResult());
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
                $attr = $this->getSpecializationAttrName($type);
                $this->filters[$attr] = $post->ID;
                return $this;
            }
        }
        
        return $this;
    }
    
    protected function buildQuery()
    {
        $this->query = array();
        $this->meta_query = array('relation' => 'AND');
        $this->query = array(
            'post_type' => 'players',
            'post_status' => 'publish',
            'meta_query' => &$this->meta_query,
            'numberposts' => -1
        );
        
        if (isset($this->filters['numberposts'])) {
            $this->query['numberposts'] = (int)$this->filters['numberposts'];
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
        
        return $this;
    }
    
    static public function prepareMetaValue($string)
    {
        if (is_array($string)) {
            return $string;
        }

        $values = explode(', ', $string);
        if (is_array($values) && count($values) !== 0) {
            return $values;
        }

        return array();
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