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

class StorageCombine extends AbstractStorage
{
    protected $patches = array();
    
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
            $data = array_merge($data, $file_data);
        }
        
        return $data;
    }
    
    public function addFilePath($file_path)
    {
        if (!in_array($file_path, $this->include) && file_exists($file_path)) {
            $this->include[] = $file_path;
        }
        
        return $this;
    }
    
    public function getPatches()
    {
        return $this->patches;
    }
    
    public function setPatches($array)
    {
        $this->patches = $array;
        
        return $this;
    }
}