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

class StorageCombineUnique extends StorageCombine
{
    /**
     * Return storage data
     * 
     * @return array
     */
    public function readStorage()
    {
        $data = array();
        foreach ($this->getPatches() as $file_path) {
            if ( !file_exists($file_path) ) {
                continue;
            }
            
            $file_data = include $file_path;
            foreach ($file_data as $object_data) {
                
                if (isset($object_data['id'])) {
                    $exist_key = $this->existsObjectInArray($data, $object_data['id']);
                    if ($exist_key !== false) {
                        unset($data[$exist_key]);
                    }
                }
                
                $data[] = $object_data;
            }
        }
        
        return $data;
    }
    
    static function existsObjectInArray($data, $id, $id_name = 'id')
    {
        foreach ($data as $key => $object_data) {
            if (isset($object_data[$id_name]) && $object_data[$id_name] === $id) {
                return $key;
            }
        }
        
        return false;
    }
}