<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\AjaxController;

/**
 * Нужны права доступа
 */
class ModelController extends AbstractRESTController
{
    protected $ModelType = null;
    
    protected $Factory = null;

    public function get($id)
    {
        $Factory = $this->getFactory();
        $Model = $Factory->get($id);
        
        if ($Model) {
            return $Model->toJSON();
        }
        
        return new \WP_Error( 'not_found', 'not_found', array( 'status' => 404 ) );
    }
    
    public function getList($params = array())
    {
        $Factory = $this->getFactory();
        $Factory->query($params);
        $ResultModels = $Factory->getResult();
        
        $result = array();
        foreach ($ResultModels as $Model) {
            $result[] = $Model->toJSON();
        }
        
        return $result;
    }
    
    public function create($data)
    {
        $Model = $this->getFactory()->initModel($data);
        $Model->save();
        
        return $Model->toJSON();
    }
    
    public function update($id, $data)
    {
        $Factory = $this->getFactory();
        $Model = $Factory->get($id);
        if (!$Model) {
            return $this->create($data);
        }
        $Model->exchange($data);
        $Model->save();
        
        return $Model->toJSON();
    }
    
    public function delete($id)
    {
        $Factory = $this->getFactory();
        $Model = $Factory->get($id);
        
        if ($Model) {
            $Model->delete();
        }
        
        return true;
    }
    
    public function setFactory(\WPObjects\Factory\FactoryInterface $Factory)
    {
        $this->Factory = $Factory;
        
        return $this;
    }
    
    /**
     * @return \WPObjects\Factory\AbstractModelFactory
     * @throws \Exception
     */
    public function getFactory()
    {
        if (is_null($this->Factory)) {
            throw new \Exception('Undefined model factory in Typical Model REST Controller!');
        }
        
        return $this->Factory;
    }
}