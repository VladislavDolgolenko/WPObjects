<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\AjaxController;

abstract Class AbstractRESTController implements
    \WPObjects\EventManager\ListenerInterface,
    \WPObjects\AjaxController\RESTInterface,
    \WPObjects\Service\NamespaceInterface
{
    protected $namespace = null;
    protected $object_type_name = null;
    
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    
    /**
     * @var \WP_REST_Request
     */
    protected $Request = null;
    
    public function attach()
    {
        \add_action( 'rest_api_init', array($this, '_register'));
    }
    
    public function detach()
    {
        \remove_action( 'rest_api_init', array($this, '_register'));
    }
    
    public function _register()
    {
        $namespace = $this->getNamespace();
        if (!$namespace) {
            throw new \Exception('Undefined namespace for REST controller!');
        }
        
        \register_rest_route($namespace, $this->getRoute(), array(
            'methods' => 'GET',
            'callback' => array($this, 'prepareAction'),
            'permission_callback' => array($this, 'prermissionControle'),
        ));
        
        \register_rest_route($namespace, $this->getRoute(false), array(
            'methods' => 'GET',
            'callback' => array($this, 'prepareAction'),
            'permission_callback' => array($this, 'prermissionControle'),
        ));
        
        \register_rest_route($namespace, $this->getRoute(), array(
            'methods' => 'PUT',
            'callback' => array($this, 'prepareAction'),
            'permission_callback' => array($this, 'prermissionControle'),
        ));
        
        \register_rest_route($namespace, $this->getRoute(false), array(
            'methods' => 'POST',
            'callback' => array($this, 'prepareAction'),
            'permission_callback' => array($this, 'prermissionControle'),
        ));
        
        \register_rest_route($namespace, $this->getRoute(), array(
            'methods' => 'DELETE',
            'callback' => array($this, 'prepareAction'),
            'permission_callback' => array($this, 'prermissionControle'),
        ));
    }
    
    public function prermissionControle(\WP_REST_Request $request)
    {
        $this->setRequest($request);
        
        if ($this->getRequest()->get_method() === self::METHOD_GET) {
            return true;
        }
        
        return \current_user_can('manage_options');
    }
    
    public function prepareAction(\WP_REST_Request $request)
    {
        $this->setRequest($request);
        
        $method = $this->getRequest()->get_method(); 
        $id = $this->getRequest()->get_param('id'); 
        
        $body_data = json_decode($this->getRequest()->get_body(), true);
        
        if (!$id && $method === "GET") {
            return $this->getList($this->getRequest()->get_query_params());
        } else if ($id && $method === "GET") {
            return $this->get($id, $this->getRequest()->get_query_params());
        } else if ($id && $method === "DELETE") {
            return $this->delete($id);
        } else if ($method === "POST" ) {
            return $this->create($body_data);
        } else if ($id && $method === "PUT") {
            return $this->update($id, $body_data);
        }
        
        return $this->error404();
    }
    
    /**
     * Resource not found
     * 
     * @return \WP_Error
     */
    protected function error404()
    {
        return new \WP_Error( 'resource_not_found', 'Resource not found', array( 'status' => 404 ) );
    }
    
    /**
     * Bad Request 
     * 
     * @return \WP_Error
     */
    protected function error400()
    {
        return new \WP_Error( 'bad_Request', 'Bad Request ', array( 'status' => 400 ) );
    }
    
    /**
     * Unauthorized
     * 
     * @return \WP_Error
     */
    protected function error401()
    {
        return new \WP_Error( 'unauthorized', 'Unauthorized', array( 'status' => 401 ) );
    }
    
    /**
     * Not Implemented
     * 
     * @return \WP_Error
     */
    protected function error501()
    {
        return new \WP_Error( 'not_implemented', 'Not Implemented', array( 'status' => 401 ) );
    }
    
    public function getRoute($uniq = true)
    {
        if (is_null($this->object_type_name)) {
            throw new \Exception('Undefiend object type name for REST controller!');
        }
        
        if ($uniq) {
            return '/' . $this->object_type_name . '/(?P<id>[a-zA-Z0-9-_]+)';
        } else {
            return '/' . $this->object_type_name . '';
        }
    }
    
    /**
     * @return \WP_REST_Request
     */
    public function getRequest()
    {
        return $this->Request;
    }
    
    public function setRequest(\WP_REST_Request $request)
    {
        $this->Request = $request;
                
        return $this;
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