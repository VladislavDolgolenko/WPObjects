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
class TypicalModelController extends AbstractRESTController
{
    protected $ModelType = null;
    
    protected $Factory = null;

    public function get($id)
    {
        $Factory = $this->getFactory();
        $Model = $Factory->get($id);
        
        if ($Model) {
            return $Model->getArrayCopy();
        }
        
        return new \WP_Error( 'not_found', 'not_found', array( 'status' => 404 ) );
    }
    
    public function getList($params = null)
    {
        $Factory = $this->getFactory();
        $Factory->query($params);
        $ResultModels = $Factory->getResult();
        
        $result = array();
        foreach ($ResultModels as $Model) {
            $result[] = $Model->getArrayCopy();
        }
        
        return $result;
    }
    
    public function create($data)
    {
        $Model = $this->getModelType()->initModel($data);
        $Model->save();
        
        return $Model->getArrayCopy();
    }
    
    public function update($id, $data)
    {
        $Factory = $this->getFactory();
        $Model = $Factory->get($id);
        $Model->exchange($data);
        $Model->save();
        
        return $Model->getArrayCopy();
    }
    
    public function delete($id)
    {
        $Factory = $this->getFactory();
        $Model = $Factory->get($id);
        $Model->delete();
        
        return true;
    }
    
    public function setFactory(\WPObjects\Factory\AbstractModelFactory $Factory)
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