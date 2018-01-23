<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
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
        return json_encode($StorageData);
    }
    
    public function get($id)
    {
        if ($this->getSessionStorage()->getSessionId() !== $id && 
            !\current_user_can('manage_options')) {
            return $this->error401();
        }
        
        $data = $this->getSessionStorage()->getData();
        $data['id'] = $id;
        
        return json_encode($data);
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