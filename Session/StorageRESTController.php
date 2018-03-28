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

namespace WPObjects\Session;

class StorageRESTController extends \WPObjects\AjaxController\AbstractRESTController implements
    \WPObjects\Session\StorageInterface
{
    protected $SessionStorage = null;
    
    protected $object_type_name = 'session_storage';
    
    public function getList($params = null)
    {
        if (!\current_user_can('manage_options')) {
            return $this->error401();
        }
        
        $StorageData = $this->getSessionStorage()->getStoragesData();
        return $StorageData;
    }
    
    public function get($id)
    {
        if ($this->getSessionStorage()->getSessionId() !== $id && 
            !\current_user_can('manage_options')) {
            return $this->error401();
        }
        
        $data = $this->getSessionStorage()->getData();
        $data['id'] = $id;
        
        return $data;
    }
    
    public function create($data)
    {
        return $this->error404();
    }
    
    public function delete($id)
    {
        return $this->error404();
    }
    
    public function update($id, $data)
    {
        if ($this->getSessionStorage()->getSessionId() !== $id && 
            !\current_user_can('manage_options')) {
            return $this->error401();
        }
        
        if (isset($data['property_compare_ids'])) {
            $this->getSessionStorage()->set('property_compare_ids', $data['property_compare_ids']);
            $this->getSessionStorage()->update();
        }
        
        return $this->get($id);
    }
    
    public function prermissionControle(\WP_REST_Request $request)
    {
        return true;
    }
    
    public function setSessionStorage(\WPObjects\Session\Storage $Storage)
    {
        $this->SessionStorage = $Storage;
        
        return $this;
    }
    
    /**
     * @return \WPObjects\Session\Storage
     */
    public function getSessionStorage()
    {
        return $this->SessionStorage;
    }
}