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

    private $datas = array();
    private $datas_objects = array();
    private $active_datas = array();
    private $active_datas_objects = array();
    private $data_disables = array();
    private static $_instances = array();
    
    protected $wp_option_prefix = null;
    protected $datas_config_file_patch = null;
    protected $datas_path = null;

    /**
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
    
    public function resetCache()
    {
        $this->datas = null;
        $this->datas_objects = null;
        $this->active_datas = null;
        $this->active_datas_objects = null;
        $this->data_disables = null;
    }
    
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

            $key = $this->getDataIdentetyKey($datas[0]);

            $result_datas = array();
            foreach ($datas as $data) {

                if ( $this->isActiveData($Storage, $data[$key]) === true ) {
                    $result_datas[] = $data;
                }

            }

            return $result_datas;
        }
        
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
            
            foreach ($build_in as $key => $data) {
                $build_in[$key]['build_in'] = true;
            }

            $custom = get_option($this->wp_option_prefix . '_data_' . $Storage->getId(), array());

            return array_merge($custom, $build_in);
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
        
    static public function getDataIdentetyKey($data)
    {
        if (isset($data['id'])) {
            return 'id';
        } else if (isset($data['slug'])) {
            return 'slug';
        } else if ($data['key']) {
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
