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

namespace WPObjects\Data;

class Data implements
    \WPObjects\Service\NamespaceInterface
{

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
        unset($this->data_disables[$storage_id]);
        
        return $this;
    }

/*
 * Data getting 
 */
        
    public function getDatas(\WPObjects\Data\AbstractStorage $Storage)
    {
        if (isset($this->datas[$Storage->getId()])) {
            return $this->datas[$Storage->getId()];
        }
        
        $datas = $this->extractDatas($Storage);
        $this->datas[$Storage->getId()] = $datas;
        return $datas;
    }
    
        protected function extractDatas(\WPObjects\Data\StorageDataInterface $Storage)
        {
            $storage_data = $Storage->getData();
            
            $build_in = $this->filterBuildInData($storage_data, $Storage);
            $custom = array_reverse($this->readStorageData($Storage));
            
            $result = array_merge($custom, $build_in);
            $filtered_result = $this->filterResultData($result, $Storage);
            
            return $filtered_result;
        }
        
        protected function filterBuildInData($datas, \WPObjects\Data\AbstractStorage $Storage)
        {
            foreach ($datas as $key => $data) {
                $datas[$key]['build_in'] = true;
            }
            
            return $datas;
        }
        
        protected function filterResultData($datas, \WPObjects\Data\AbstractStorage $Storage)
        {
            if (!count($datas)) {
                return $datas;
            }
            
            foreach ($datas as $index => $data) {
                $key = $this->getDataIdentetyKey($data);
                if (isset($data[$key]) && $this->isActiveData($Storage, $data[$key]) === true) {
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
        
    public function isActiveData(\WPObjects\Data\AbstractStorage $Storage, $data_id)
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
        $Model->getModelType()->getFactory()->resetCache();
        
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
    
    protected function writeStorageData(\WPObjects\Data\AbstractStorage $Storage, $data)
    {
        $option_key = $this->getDataTypeWpOptionKey($Storage->getId());
        update_option($option_key, $data);
    }
    
    protected function readStorageData(\WPObjects\Data\AbstractStorage $Storage)
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
        $Model->getModelType()->getFactory()->resetCache();
        
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
        } else if (isset($data['base'])) {
            return 'base';
        } else if (isset($data['family'])) {
            return 'family';
        }

        return false;
    }
    
    public function getDataTypeWpOptionKey($datas_type_id)
    {
        return $this->wp_option_prefix . '_data_' . $datas_type_id;
    }
    
    public function getDataTypeWpOptionKeyDisables($datas_type_id)
    {
        return $this->wp_option_prefix . '_data_' . $datas_type_id . '_disables';
    }
    
    public function setNamespace($string)
    {
        $this->wp_option_prefix = $string;
    }
    
    public function getNamespace()
    {
        return $this->wp_option_prefix;
    }
    
/*
 * Export & Import
 */
    
    public function export($Storages)
    {
        $result = array();
        foreach ($Storages as $Storage) {
            $key_options = $this->getDataTypeWpOptionKey((string)$Storage->getId());
            $key_disables = $this->getDataTypeWpOptionKeyDisables((string)$Storage->getId());
            
            $result[$key_disables] = $this->extractDataDisables($Storage->getId());
            $result[$key_options] = $this->readStorageData($Storage); 
        }
        
        return $result;
    }
    
    public function cleanStorages($Storages)
    {
        if (!is_array($Storages)) {
            $Storages = array($Storages);
        }
        
        foreach ($Storages as $Storage) {
            $key_options = $this->getDataTypeWpOptionKey((string)$Storage->getId());
            $key_disables = $this->getDataTypeWpOptionKeyDisables((string)$Storage->getId());
            
            delete_option($key_options);
            delete_option($key_disables);
        }
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
