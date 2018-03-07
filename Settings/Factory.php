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

namespace WPObjects\Settings;

use WPObjects\Settings\Model;

class Factory extends \WPObjects\Factory\AbstractData
{
    public function initModel($data)
    {
        $SettingModel = new Model($data);
        return $this->getServiceManager()->inject($SettingModel);
    }
    
    /**
     * Return current setting value by setting id
     * 
     * @param string $setting_id
     * @return mixed
     */
    public function getValue($setting_id)
    {
        $Setting = $this->get($setting_id);
        if (!$Setting) {
            return null;
        }
        
        return $Setting->getCurrentValue();
    }
    
    public function getGrouped()
    {
        $Settings = $this->query()->getResult();
        
        $result = array();
        foreach ($Settings as $Setting) {
            $groupe = $Setting->getGroup();
            if (!isset($result[$groupe])) {
                $result[$groupe] = array();
            }
            
            $result[$groupe][] = $Setting;
        }
        
        return $result;
    }
    
    public function getByGroupName($group_name)
    {
        return $this->query(array(
            'group' => $group_name
        ))->getResult();
    }
    
    public function getGroups()
    {
        $Settings = $this->query()->getResult();
        
        $groups_names = array();
        foreach ($Settings as $Setting) {
            $group_name = $Setting->getGroup();
            if (!in_array($group_name, $groups_names)) {
                $groups_names[] = $group_name;
            }
        }
        
        $Groups = array();
        foreach ($groups_names as $group_name) {
            $group_id = str_replace(array('`', ' ', "'", '-', '.', ','), '_', $group_name);
            $Groups[] = array(
                'id' => $group_id,
                'name' => $group_name,
            );
        }
        
        return $Groups;
    }
}