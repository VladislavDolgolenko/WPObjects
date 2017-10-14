<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Factory\FilterHandler;

class Agregators
{
    protected function attach(\WPObjects\EventManager\Manager $EventManager)
    {
        $EventManager->addListener('prepare_filters', array($this, $this->setUpQueryByAgregators));
    }
    
    protected function setUpQueryByAgregators($Factory)
    {
        $ModelType = $Factory->getModelType();
        $filters = $Factory->getFilters();
        
        foreach ($filters as $model_type_id => $value) {
            $AgregatorType = $this->getAgregatorType($model_type_id);
            if (!$AgregatorType) {
                continue;
            }
            
            $Factory = $AgregatorType->getFactory();
            if (!$Factory instanceof \WPObjects\Factory\AbstractModelFactory) {
                throw new \Exception('Undefined factory of agregator type');
            }
            
            $filter_ids = array();
            $AgregatorsObjects = $Factory->get($value);
            $qualifier_attr_name = $ModelType->getOwnQualifierAttrName();
            foreach ($AgregatorsObjects as $AgregatorObject) {
                $ids = $AgregatorObject->getMeta($qualifier_attr_name);
                if (!is_array($ids)) {
                    $ids = array($ids);
                }
                $filter_ids[] = $ids;
            }
            
            // Это пизда post__in
            $filters['id'] = array_filter($filter_ids);
        }
        
        $Factory->setFilters($filters);
    }
}