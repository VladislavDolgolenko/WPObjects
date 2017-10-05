<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\PostType;

class PostType implements \WPObjects\EventManager\ListenerInterface
{
    private static $_instances = array();
    
    protected $id = null;
    protected $config = array();
    protected $model_class = '\WPObjects\Model\AbstractPostModel';
    
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
    
    public function __construct($id = null)
    {
        $this->id = $id;
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
    
    public function getModelClass()
    {
        $config = $this->getConfig();
        if (isset($config['model_class']) && class_exists($config['model_class'])) {
            $this->model_class = $config['model_class'];
        }
        
        return $this->model_class;
    }
    
    public function setModelClass($class_name)
    {
        $this->model_class = $class_name;
        
        return $this;
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

