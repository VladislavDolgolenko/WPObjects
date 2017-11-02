<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Data;

class Data {

    /**
     * Singleton instance  
     * 
     * @var \WPObjects\Data\Data
     */
    private static $_instances = array();
    
    /**
     * Source data by types
     * 
     * @var array 
     */
    private $datas = array();
    
    /**
     * Source data by types as \ArrayObject
     * 
     * @var \ArrayObject
     */
    private $datas_objects = array();
    
    /**
     * Active data by types
     * 
     * @var array
     */
    private $active_datas = array();
    
    /**
     * Active data by types as \ArrayObject
     * 
     * @var \ArrayObject
     */
    private $active_datas_objects = array();
    
    /**
     * Informations of disables data intities 
     * 
     * @var type 
     */
    private $data_disables = array();
    
    /**
     * Prefix for db where data stored as WordPress options
     * 
     * @var type 
     */
    protected $wp_option_prefix = null;

    /**
     * Return singleton instance  
     * 
     * @return \MSP\Data\Data
     */
    static public function getInstance()
    {
        $class = get_called_class();
        if (!isset(self::$_instances[$class])) {
            self::$_instances[$class] = new $class();
        }
        
        return self::$_instances[$class];
    }
    
    /**
     * Reset cache
     * 
     * @return $this
     */
    public function resetCache($storage_id)
    {
        unset($this->datas[$storage_id]);
        unset($this->datas_objects[$storage_id]);
        unset($this->active_datas[$storage_id]);
        unset($this->active_datas_objects[$storage_id]);
        unset($this->data_disables[$storage_id]);
        
        return $this;
    }
    
/*
 * Data getting with active status
 */
    
    public function getActiveDatasObjects(\WPObjects\Data\Storage $Storage)
    {
        if (isset($this->active_datas_objects[$Storage->getId()])) {
            return $this->active_datas_objects[$Storage->getId()];
        }
        
        $datas = $this->getActiveDatas($Storage);
        $result = array();
        foreach ($datas as $data) {
            $result[] = new \ArrayObject($data, \ArrayObject::ARRAY_AS_PROPS);
        }

        $this->active_datas_objects[$Storage->getId()] = $result;
        return $result;
    }
    
    public function getActiveDatas(\WPObjects\Data\Storage $Storage)
    {
        if (isset($this->active_datas[$Storage->getId()])) {
            return $this->active_datas[$Storage->getId()];
        }
        
        $datas = $this->extractActiveDatas($Storage);
        $this->active_datas[$Storage->getId()] = $datas;
        return $datas;
    }
    
        private function extractActiveDatas(\WPObjects\Data\Storage $Storage)
        {
            $datas = $this->getDatas($Storage);
            if (count($datas) === 0) {
                return array();
            }

            $result_datas = array();
            foreach ($datas as $data) {
                if ($data['active'] === true) {
                    $result_datas[] = $data;
                }
            }

            return $result_datas;
        }

/*
 * Data getting 
 */
        
    public function getDatasObjects(\WPObjects\Data\Storage $Storage)
    {
        if (isset($this->datas_objects[$Storage->getId()])) {
            return $this->datas_objects[$Storage->getId()];
        }
        
        $datas = $this->getDatas($Storage);
        $result = array();
        foreach ($datas as $data) {
            $result[] = new \ArrayObject($data, \ArrayObject::ARRAY_AS_PROPS);
        }

        $this->datas_objects[$Storage->getId()] = $result;
        return $result;
    }
    
    public function getDatas(\WPObjects\Data\Storage $Storage)
    {
        if (isset($this->datas[$Storage->getId()])) {
            return $this->datas[$Storage->getId()];
        }
        
        $datas = $this->extractDatas($Storage);
        $this->datas[$Storage->getId()] = $datas;
        return $datas;
    }
    
        protected function extractDatas(\WPObjects\Data\Storage $Storage)
        {
            if ($Storage->getFilePath() && file_exists($Storage->getFilePath())) {
                $build_in = (include $Storage->getFilePath());
                \WPObjects\Log\Loger::getInstance()->write("Storage: " . $Storage->getFilePath() );
            } else {
                \WPObjects\Log\Loger::getInstance()->write("ERROR Storage file not exists: " . $Storage->getFilePath() );
                $build_in = array();
            }
            
            $build_in = $this->filterBuildInData($build_in, $Storage);
            $custom = $this->readStorageData($Storage);
            
            $result = array_merge($custom, $build_in);
            $filtered_result = $this->filterResultData($result, $Storage);
            
            return $filtered_result;
        }
        
        protected function filterBuildInData($datas, \WPObjects\Data\Storage $Storage)
        {
            foreach ($datas as $key => $data) {
                $datas[$key]['build_in'] = true;
            }
            
            return $datas;
        }
        
        protected function filterResultData($datas, \WPObjects\Data\Storage $Storage)
        {
            if (!count($datas)) {
                return $datas;
            }
            
            foreach ($datas as $index => $data) {
                $key = $this->getDataIdentetyKey($data);
                if ($this->isActiveData($Storage, $data[$key]) === true) {
                    $datas[$index]['active'] = true;
                } else {
                    $datas[$index]['active'] = false;
                }
            }
            
            return $datas;
        }
        
/*
 * Data active status 
 */
        
    public function isActiveData(\WPObjects\Data\Storage $Storage, $data_id)
    {
        $activity = $this->getDataDisables($Storage->getId());

        if (!isset($Storage->activity) && !in_array($data_id, $activity)) {
            return true;

        // If invert type
        } elseif (isset($Storage->activity) && in_array($data_id, $activity)) {
            return true;
        }

        return false;
    }
    
    public function getDataDisables($datas_type)
    {
        if (isset($this->data_disables[$datas_type])) {
            return $this->data_disables[$datas_type];
        }
        
        $datas = $this->extractDataDisables($datas_type);
        $this->data_disables[$datas_type] = $datas;
        return $datas;
    }
    
        private function extractDataDisables($datas_type)
        {
            $disablement_key = $this->getDataTypeWpOptionKeyDisables($datas_type);
            $disable_datas_keys = get_option($disablement_key, array() );
            if (! is_array($disable_datas_keys)) {
                return array();
            }

            return $disable_datas_keys;
        }
        
    protected function updateModelStatus(\WPObjects\Model\AbstractDataModel $Model)
    {
        $Storage = $Model->getModelType()->getStorage();
        $disables = $this->getDataDisables($Storage->getId());
        $index = array_search($Model->getId(), $disables);
        $is_status = isset($Storage->activity) ? !$Model->isActive() : $Model->isActive();
        
        if ($is_status && $index !== false) {
            unset($disables[$index]);
        } else if (!$is_status && $index === false) {
            $disables[] = $Model->getId();
        }
        
        $disablement_key = $this->getDataTypeWpOptionKeyDisables($Storage->getId());
        update_option($disablement_key, $disables);
        
        return $this;
    }

    protected function deleteModelStatus(\WPObjects\Model\AbstractDataModel $Model)
    {
        $Storage = $Model->getModelType()->getStorage();
        $disables = $this->getDataDisables($Storage->getId());
        if (in_array($Model->getId(), $disables)) {
            $index = array_search($Model->getId(), $disables);
            unset($disables[$index]);
        }
        
        $disablement_key = $this->getDataTypeWpOptionKeyDisables($Storage->getId());
        update_option($disablement_key, $disables);
        
        return $this;
    }
    
/*
 * Saving
 */

    /**
     * Saving model instance in to database through WordPress options
     * 
     * Model mast have identity!
     * 
     * @param \WPObjects\Model\AbstractDataModel $Model
     * @return boolean
     * @throws \Exception
     */
    public function saveModel(\WPObjects\Model\AbstractDataModel $Model)
    {
        if (!$Model->getId()) {
            throw new \Exception('Undefined model id. Model Can\'t to save.');
        }
        
        $Storage = $Model->getModelType()->getStorage();
        $all_datas = $this->readStorageData($Storage);
        $index = $this->getIndexById($Model->getId(), $Model->getModelType());
        
        if ($index !== false) {
            $all_datas[$index] = array_merge($all_datas[$index], $Model->toJSON());
        } else {
            $all_datas[] = $Model->toJSON();
        }
        
        if (!$Model->isBuildIn()) {
            $this->writeStorageData($Storage, $all_datas);
        }
        
        $this->updateModelStatus($Model);
        
        $this->resetCache($Storage->getId());
        
        return $this;
    }
    
    public function getIndexById($id, \WPObjects\Model\AbstractModelType $ModelType)
    {
        $Storage = $ModelType->getStorage();
        $id_attr = $ModelType->getIdAttrName();
        
        $all_datas = $this->readStorageData($Storage);
        foreach ($all_datas as $index => $model_data) {
            if ($model_data[$id_attr] == $id) {
                return $index;
            }
        }
        
        return false;
    }
    
    protected function writeStorageData(\WPObjects\Data\Storage $Storage, $data)
    {
        $option_key = $this->getDataTypeWpOptionKey($Storage->getId());
        update_option($option_key, $data);
    }
    
    protected function readStorageData(\WPObjects\Data\Storage $Storage)
    {
        $option_key = $this->getDataTypeWpOptionKey($Storage->getId());
        return get_option($option_key, array());
    }
  
    public function deleteModel(\WPObjects\Model\AbstractDataModel $Model)
    {
        $Storage = $Model->getModelType()->getStorage();
        $all_datas = $this->readStorageData($Storage);
        
        $index = $this->getIndexById($Model->getId(), $Model->getModelType());
        if ($index === false) {
            return $this;
        }
        
        unset($all_datas[$index]);
        $this->writeStorageData($Storage, $all_datas);
        $this->resetCache($Storage->getId());
        
        $this->deleteModelStatus($Model);
        
        return $this;
    }
    
/*
 * Configurations
 */    
    
    static public function getDataIdentetyKey($data)
    {
        if (isset($data['id'])) {
            return 'id';
        } else if (isset($data['ID'])) {
            return 'ID';
        } else if (isset($data['slug'])) {
            return 'slug';
        } else if (isset($data['key'])) {
            return 'key';
        }

        return false;
    }
    
    public function getDataTypeWpOptionKey($datas_type_id)
    {
        return $this->wp_option_prefix . '_data_' . $datas_type_id;
    }
    
    public function getDataTypeWpOptionKeyDelete($datas_type_id)
    {
        return $this->wp_option_prefix . '_data_' . $datas_type_id . '_delete';
    }
    
    public function getDataTypeWpOptionKeyDisables($datas_type_id)
    {
        return $this->wp_option_prefix . '_data_' . $datas_type_id . '_disables';
    }
    
/*
 * Export & Import
 */
    
    // export 
    public function export()
    {
        $DataTypes = $this->getDataTypes();
        
        $result = array();
        foreach ($DataTypes as $DataType) {
            $key_options = $this->getDataTypeWpOptionKey((string)$DataType->id);
            $key_disables = $this->getDataTypeWpOptionKeyDisables((string)$DataType->id);
            
            $result[$key_options] = get_option($key_options, array() ); 
            $result[$key_disables] = get_option($key_disables, array() ); 
        }
        
        return $result;
    }
    
    public function translateExportToJSON($datas)
    {
        $data_json = json_encode($datas);
        header("Content-type: application/x-msdownload",true,200);
        header("Content-Disposition: attachment; filename=export.json");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $data_json;
        exit();
    }
    
    public function importJSON($json)
    {
        $wp_data_options = json_decode($json, true);
        
        foreach ($wp_data_options as $key => $options) {
            update_option($key, $options);
        }
        
        return true;
    }
    
    

}
