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
    private $data_types = null;
    private $querys_count = 0;
    private static $_instance = null;
    
    protected $wp_option_prefix = null;
    protected $datas_config_file_patch = null;
    protected $datas_path = null;

    public function __construct()
    {
        
    }
    
    /**
     * @return \MSP\Data\Data
     */
    static public function getInstance()
    {
        $class = get_called_class();
        if (is_null(self::$_instance)) {
            self::$_instance = new $class();
        }
        
        return self::$_instance;
    }
    
    public function resetCache()
    {
        $this->datas = null;
        $this->datas_objects = null;
        $this->active_datas = null;
        $this->active_datas_objects = null;
        $this->data_disables = null;
    }
    
    public function getActiveDatasObjects($datas_type_id)
    {
        if (isset($this->active_datas_objects[$datas_type_id])) {
            return $this->active_datas_objects[$datas_type_id];
        }
        
        $datas = $this->getActiveDatas($datas_type_id);
        $result = array();
        foreach ($datas as $data) {
            $result[] = new \ArrayObject($data, \ArrayObject::ARRAY_AS_PROPS);
        }

        $this->active_datas_objects[$datas_type_id] = $result;
        return $result;
    }
    
    public function getActiveDatas($datas_type_id)
    {
        if (isset($this->active_datas[$datas_type_id])) {
            return $this->active_datas[$datas_type_id];
        }
        
        $datas = $this->extractActiveDatas($datas_type_id);
        $this->active_datas[$datas_type_id] = $datas;
        return $datas;
    }
    
        private function extractActiveDatas($datas_type_id)
        {
            $datas = $this->getDatas($datas_type_id);
            if (count($datas) === 0) {
                return array();
            }

            $key = $this->getDataIdentetyKey($datas[0]);

            $result_datas = array();
            foreach ($datas as $data) {

                if ( $this->isActiveData($datas_type_id, $data[$key]) === true ) {
                    $result_datas[] = $data;
                }

            }

            return $result_datas;
        }
        
    public function isActiveData($datas_type_id, $data_id)
    {
        $activity = $this->getDataDisables($datas_type_id);
        $data_type = msp__get_data_type_by_id($datas_type_id);

        if (!isset($data_type->activity) && !in_array($data_id, $activity)) {
            return true;

        // If invert type
        } elseif (isset($data_type->activity) && in_array($data_id, $activity)) {
            return true;
        }

        return false;
    }

    public function getDatasObjects($datas_type_id)
    {
        if (isset($this->datas_objects[$datas_type_id])) {
            return $this->datas_objects[$datas_type_id];
        }
        
        $datas = $this->getDatas($datas_type_id);
        $result = array();
        foreach ($datas as $data) {
            $result[] = new \ArrayObject($data, \ArrayObject::ARRAY_AS_PROPS);
        }

        $this->datas_objects[$datas_type_id] = $result;
        return $result;
    }
    
    public function getDatas($datas_type)
    {
        if (isset($this->datas[$datas_type])) {
            return $this->datas[$datas_type];
        }
        
        $datas = $this->extractDatas($datas_type);
        $this->datas[$datas_type] = $datas;
        return $datas;
    }
    
        protected function extractDatas($datas_type)
        {
            // Что это блять за функция
            $data_type = msp__get_data_type_by_id($datas_type);
            $build_in =  (include $this->getDatasPath() . '/' . $datas_type . '.php' );
            foreach ($build_in as $key => $data) {
                $build_in[$key]['build_in'] = true;

                if (isset($data_type->has_images) && $data_type->has_images) {
                    $identety_key = $this->getDataIdentetyKey($data);
                    $build_in[$key]['img_url'] = $this->getDataTypeImageUrl((string)$data_type->id, $data[$identety_key]);
                    $build_in[$key]['img_url_mini'] = $this->getDataTypeImageUrl((string)$data_type->id, $data[$identety_key], 'mini');
                }
            }

            $custom = get_option($this->wp_option_prefix . '_data_' . $datas_type, array());

            return array_merge($custom, $build_in);
        }
        
        static public function getDataTypeImageUrl($data_type_id, $data_id, $size = '')
        {
            return null;
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
    
    public function getDataTypes()
    {
        if (is_null($this->data_types)) {
            $this->data_types = $this->extractDataTypes();
        }
        
        return $this->data_types;
    }
    
        private function extractDataTypes()
        {
            $datas = (include $this->datas_config_file_patch);

            $result = array();
            foreach ($datas as $data) {
                $result[] = new \ArrayObject($data, \ArrayObject::ARRAY_AS_PROPS);
            }

            return $result;
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
