<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\AjaxController;

abstract Class AbstractRESTController implements
    \WPObjects\EventManager\ListenerInterface,
    \WPObjects\AjaxController\RESTInterface
{
    protected $namespace = null;
    protected $object_type_name = null;
    
    public function attach()
    {
        \add_action( 'rest_api_init', array($this, 'register'));
    }
    
    public function detach()
    {
        \remove_action( 'rest_api_init', array($this, 'register'));
    }
    
    public function register()
    {
        \WPObjects\Log\Loger::getInstance()->write('REST regiter:' . $this->getObjectTypeName());
        
        $namespace = $this->getNamespace();
        if (!$namespace) {
            throw new \Exception('Undefined namespace for REST controller!');
        }
        
        \register_rest_route($namespace, $this->getRoute(), array(
            'methods' => 'GET',
            'callback' => array($this, 'prepareAction'),
        ));
        
        \register_rest_route($namespace, $this->getRoute(false), array(
            'methods' => 'GET',
            'callback' => array($this, 'prepareAction'),
        ));
        
        \register_rest_route($namespace, $this->getRoute(), array(
            'methods' => 'PUT',
            'callback' => array($this, 'prepareAction'),
        ));
        
        \register_rest_route($namespace, $this->getRoute(false), array(
            'methods' => 'POST',
            'callback' => array($this, 'prepareAction'),
        ));
        
        \register_rest_route($namespace, $this->getRoute(), array(
            'methods' => 'DELETE',
            'callback' => array($this, 'prepareAction'),
        ));
    }
    
    public function prepareAction(\WP_REST_Request $request)
    {
        $method = $request->get_method(); 
        $id = $request->get_param('id'); 
        
        if (!$id && $method === "GET") {
            return $this->getList($request->get_query_params());
        } else if ($id && $method === "GET") {
            return $this->get($id);
        } else if ($id && $method === "DELETE" && current_user_can( 'manage_options' )) {
            return $this->delete($id);
        } else if ($method === "CREATE" && current_user_can( 'manage_options' )) {
            return $this->create($request->get_body_params());
        } else if ($id && $method === "UPDATE" && current_user_can( 'manage_options' )) {
            return $this->update($id, $request->get_body_params());
        }
        
        return new \WP_Error( 'mewthod_not_allowed', 'Method not allowed', array( 'status' => 404 ) );
    }
    
    public function getRoute($uniq = true)
    {
        if (is_null($this->object_type_name)) {
            throw new \Exception('Undefiend object type name for REST controller!');
        }
        
        if ($uniq) {
            return '/' . $this->object_type_name . '/(?P<id>[a-zA-Z0-9-]+)';
        } else {
            return '/' . $this->object_type_name . '';
        }
    }
    
    public function setNamespace($string)
    {
        $this->namespace = $string;
    }
    
    public function getNamespace()
    {
        return $this->namespace;
    }
    
    public function setObjectTypeName($string)
    {
        $this->object_type_name = $string;
    }
    
    public function getObjectTypeName()
    {
        return $this->object_type_name;
    }
}