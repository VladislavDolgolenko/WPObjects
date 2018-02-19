<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\Factory\FilterHendler;

class WordPressContext implements
    \WPObjects\EventManager\ListenerAggregateInterface
{
    /**
     * @var \WPObjects\Factory\AbstractModelFactory
     */
    protected $Factory = null;
    
    /**
     * @var array
     */
    protected $filters = null;
    
    public function attach(\WPObjects\EventManager\Manager $EventManager)
    {
        $EventManager->attach('set_query_filters', array($this, 'handler'));
    }
    
    public function detach(\WPObjects\EventManager\Manager $EventManager)
    {
        $EventManager->detach('set_query_filters', array($this, 'handler'));
    }
    
    public function handler(\WPObjects\Factory\AbstractModelFactory $Factory)
    {
        $this->Factory = $Factory;
        $this->filters = $Factory->getFilters();
        
        if (!isset($this->filters['page_context']) || !$this->filters['page_context']) {
            return;
        }
        
        global $post;
        $ModelType = $this->getModelType()->getContextModelType($post);
        if (is_null($ModelType)) {
            return;
        }
        
        $ContextModel = $ModelType->initModel($post);
        if ($ContextModel->getModelType()->getId() === $this->getFactory()->getModelType()->getId()) {
            $this->filters[$this->getFactory()->getIdAttrName()] = $ContextModel->getId();
        } else {
            $this->setUpContextToFilters($ContextModel);
        }
        
        $this->getFactory()->updateFilters($this->filters);
    }
    
    /**
     * @global \WP_Post $post
     * @return \WPObjects\Model\AbstractTypicalModel
     */
    protected function getContextTypicalModel()
    {
        global $post;
        $ModelType = $this->getModelType()->getContextModelType($post);
        return $ModelType->initModel($post);
    }
    
    protected function setUpContextToFilters(\WPObjects\Model\AbstractTypicalModel $ContextModel)
    {
        $attr = $this->getModelType()->getQualifierAttrName($ContextModel->getModelType()->getId());
        $callable_methods = $this->getModelType()->getContextMethodReading($ContextModel->getModelType()->getId());
        
        if (!is_callable($callable_methods)) {
            $this->filters[$attr] = $ContextModel->getId();
            $this->filters[$attr  . '_not_ordered'] = true;
        } else {
            $result = call_user_func($callable_methods, $ContextModel);
            $this->filters[$this->getFactory()->getIdAttrName()] = $result;
        }
    }
    
    /**
     * @return \WPObjects\Factory\AbstractModelFactory
     */
    protected function getFactory()
    {
        return $this->Factory;
    }
    
    /**
     * @return \WPObjects\Model\AbstractModelType
     */
    protected function getModelType()
    {
        return $this->getFactory()->getModelType();
    }
    
}