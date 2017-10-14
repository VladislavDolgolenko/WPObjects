<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Factory\FilterHandler;

class WordPressContext
{
    protected $Factory =  null;
    
    protected function attach(\WPObjects\EventManager\Manager $EventManager)
    {
        $EventManager->addListener('prepare_filters', array($this, $this->readContext));
    }
    
    public function readContext(Factory $Factory)
    {
        global $post;
        
        $this->Factory = $Factory;
        $query = $Factory->getFilters();
        
        if (!isset($this->filters['page_context'])) {
            return;
        }
        
        // Own context if first rule
        if (\get_post_type($post->ID) === $this->getModelType()) {
            $query['id'] = $post->ID;
        }
        
        foreach ($this->getContextModelTypes() as $type_id) {
            if (get_post_type($post->ID) == $type_id) {
                $this->setUpQueryContext($query, $post, $type_id);
            }
        }
    }
    
    protected function setUpQueryContext($post, $type)
    {
        $attr = $this->getSpecializationAttrName($type);
        $query = $this->Factory->getFilters();
        
        if (!isset($this->context_methods_reading[$type]) && is_callable($this->context_methods_reading[$type])) {
            $query[$attr] = $post->ID;
        } else {
            $method = $this->context_methods_reading[$type];
            $method->bindTo($this);
            $query['post__in'] = $method($post);
        }
        
        $this->Factory->setFilters($query);
    }
}