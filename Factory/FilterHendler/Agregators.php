<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Factory\FilterHendler;

class Agregators implements
    \WPObjects\EventManager\ListenerAggregateInterface
{
    
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
        $ModelType = $Factory->getModelType();
        $filters = $Factory->getFilters();
        
        // Filter name as model type id
        foreach ($filters as $model_type_id => $value) {
            $AgregatorType = $ModelType->getAgregator($model_type_id);
            if (!$AgregatorType) {
                continue;
            }
            
            $Factory = $AgregatorType->getFactory();
            if (!$Factory instanceof \WPObjects\Factory\AbstractModelFactory) {
                throw new \Exception('Undefined factory of agregator type');
            }
            
            $filter_ids = array();
            $AgregatorsObjects = $Factory->get($value, array(), false);
            foreach ($AgregatorsObjects as $AgregatorObject) {
                $ids = $AgregatorObject->getQualifierId($ModelType->getId());
                if (!is_array($ids)) {
                    $ids = array($ids);
                }
                $filter_ids[] = $ids;
            }
            
            // Это пизда post__in
            $filters[$Factory->getIdAttrName()] = array_filter($filter_ids);
        }
        
        $Factory->updateFilters($filters);
    }
    
}