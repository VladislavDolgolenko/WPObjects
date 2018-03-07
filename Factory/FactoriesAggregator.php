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

namespace WPObjects\Factory;

class FactoriesAggregator implements
    \WPObjects\Factory\FactoryInterface
{
    /**
     * @var \WPObjects\Factory\FactoryInterface
     */
    protected $Factories = array();
    
    public function get($id = null, $filters = array(), $single = true)
    {
        $result = array();
        foreach ($this->Factories as $Factory) {
            $objects = $Factory->get($id, $filters, false);
            if (is_array($objects) && count($objects)) {
                $result = array_merge($result, $objects);
            }
        }
        
        if ($single) {
            return current($result);
        } else {
            return array_filter($result);
        }
    }
    
    public function query($filters = array(), $result_as_object = false)
    {
        foreach ($this->Factories as $Factory) {
            $Factory->query($filters, $result_as_object);
        }
        
        return $this;
    }
    
    public function getResultIds()
    {
        $result = array();
        foreach ($this->Factories as $Factory) {
            $result = array_merge($result, $Factory->getResultIds());
        }
        
        return array_filter($result);
    }
    
    public function getOneResult()
    {
        $Result = $this->getResult();
        
        return current($Result) ? current($Result) : null;
    }
    
    public function getResult()
    {
        $result = array();
        foreach ($this->Factories as $Factory) {
            $result = array_merge($result, $Factory->getResult());
        }   
        
        return array_filter($result);
    }
    
    public function addFactory(\WPObjects\Factory\FactoryInterface $Factory)
    {
        $this->Factories[] = $Factory;
    }
}