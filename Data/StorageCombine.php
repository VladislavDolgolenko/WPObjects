<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
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
    public function getData()
    {
        if ($this->data) {
            return $this->data;
        }
        
        foreach ($this->getPatches() as $file_path) {
            if ( !file_exists($file_path) ) {
                continue;
            }
            
            $file_data = include $file_path;
            $this->data = array_merge($this->data, $file_data);
        }
        
        return $this->data;
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