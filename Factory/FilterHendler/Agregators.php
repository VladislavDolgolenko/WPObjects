<?php

/**
 * @encoding     UTF-8
 * @package      WPObjects
 * @link         https://github.com/VladislavDolgolenko/WPObjects
 * @copyright    Copyright (C) 2018 Vladislav Dolgolenko
 * @license      MIT License
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      <help@vladislavdolgolenko.com>
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
            if (!$value) {
                continue;
            }
            
            $AgregatorType = $ModelType->getAgregator($model_type_id);
            if (!$AgregatorType) {
                continue;
            }
            
            $AgregatorFactory = $AgregatorType->getFactory();
            if (!$AgregatorFactory instanceof \WPObjects\Factory\AbstractModelFactory) {
                throw new \Exception('Undefined factory of agregator type');
            }
            
            $filter_ids = array();
            $AgregatorsObjects = $AgregatorFactory->get($value, array(), false);
            foreach ($AgregatorsObjects as $AgregatorObject) {
                $callable_methods = $ModelType->getContextMethodReading($AgregatorType->getId());
                if (!is_callable($callable_methods)) {
                    $ids = $AgregatorObject->getQualifierId($ModelType->getId());
                } else {
                    $ids = call_user_func($callable_methods, $AgregatorObject);
                }
                
                if (!is_array($ids)) {
                    $ids = array($ids);
                }
                $filter_ids = array_merge($filter_ids, $ids);
            }
            
            $filters[$Factory->getIdAttrName()] = array_filter($filter_ids);
        }
        
        $Factory->updateFilters($filters);
    }
    
}