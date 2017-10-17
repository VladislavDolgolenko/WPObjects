<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\PostType;

use WPObjects\Model\AbstractModelType;

class PostType extends AbstractModelType implements 
    \WPObjects\EventManager\ListenerInterface
{
    private static $_instances = array();
    
    /**
     * Identity of ModelType and WordPress post-type object when register
     * @var type 
     */
    protected $id = null;
    
    /**
     * identification attribute of the current model type
     * 
     * @var string
     */
    protected $id_attr_name = 'ID';
    
    /**
     * Configuration for WordPress post-type object
     * @var type 
     */
    protected $config = array();
    
    /**
     * Register custom meta attributes
     * @var array
     */
    protected $register_metas = array();
    
    /**
     * Default object attributes
     * @var array
     */
    protected $defaults_attrs = array(
        'ID',
        'post_author',
        'post_date',
        'post_date_gmt',
        'post_content',
        'post_title',
        'post_excerpt',
        'post_status',
        'comment_status',
        'ping_status',
        'post_password',
        'post_name',
        'to_ping',
        'pinged',
        'guid',
        'menu_order',
        'post_type',
        'post_mime_type',
        'comment_count'
    );
    
    /**
     * @return \WPObjects\PostType\PostType
     */
    static public function getInstance()
    {
        $class = get_called_class();
        if (!isset(self::$_instances[$class])) {
            self::$_instances[$class] = new $class();
        }
        
        return self::$_instances[$class];
    }
    
    /**
     * Initialization PostType as \WPObjects DataType model
     * @param array|string $data
     */
    public function __construct($data)
    {
        if (!is_array($data)) {
            $data = array(
                'id' => $data
            );
        }
        
        parent::__construct($data);
    }
    
    public function getModelClassName()
    {
        if (!isset($this->model_class_name)) {
            throw new \Exception('Undefined data type mode class name');
        }
        
        return $this->model_class_name;
    }
    
    public function attach()
    {
        \add_action('save_post', array($this, 'savePost'), 10, 3);
        \add_action('init', array($this, 'register'));
    }
    
    public function detach()
    {
        \remove_action('init', array($this, 'register'));
        \remove_action('save_post', array($this, 'savePost'));
    }
    
    public function register()
    {
        \register_post_type($this->getId(), $this->getConfig());
    }
    
    public function savePost($post_id, $post, $update)
    {
        global $_POST;
        if (!isset($_POST['post_type'])) {
            return;
        }

        if (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || 
            $_POST['post_type'] !== $this->getId()) {
            return;
        }
        
        $model_class = $this->getModelClass();
        $Post = new $model_class($post);
        foreach ($_POST as $attr => $value) {
            $Post->setMeta($attr, self::sanitizeValue($value));
        }
        
        $Post->saveMetas();
        return $this;
    }
    
    static public function sanitizeValue($values)
    {
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                if (!$value || $value == " ") {
                    unset($values[$key]);
                } else {
                    $values[$key] = self::sanitizeValue($value);
                }
            }
        } else {
            return \sanitize_text_field($values);
        }
    }
    
    public function setId($int)
    {
        $this->id = $int;
        
        return $this;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        $config = $this->getConfig();
        $labels = isset($config['labels']) ? $config['labels'] : array();
        $name = isset($labels['name']) ? $labels['name'] : ucfirst($this->id);
        return $name;
    }
    
    public function getDefaultAttrs()
    {
        return $this->defaults_attrs;
    }
    
    public function getRegisterMetas()
    {
        return array_merge($this->register_metas, $this->getQualifiersAttrsNames());
    }
    
    public function setConfig($config)
    {
        $this->config = $config;
        
        return $this;
    }
    
    public function getConfig()
    {
        return $this->config;
    }
}

