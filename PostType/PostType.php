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
     * WoprdPress options prefix for post-type settings 
     * @var type 
     */
    protected $settings_prefix = 'wpobjects_';
    
    /**
     * List of customazible attributes
     * 
     * @var array
     */
    protected $settings_attributes = array(
        'rewrite'
    );
    
    /**
     * @var \WPObjects\PostType\MetaBox in array
     */
    protected $MetaBoxes = array();
    
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
        $this->initSettings();
    }
    
    /**
     * Return php class name of current post-type typical model
     * 
     * @return string
     * @throws \Exception
     */
    public function getModelClassName()
    {
        if (!isset($this->model_class_name)) {
            throw new \Exception('Undefined data type mode class name');
        }
        
        return $this->model_class_name;
    }
    
    public function attach()
    {
        parent::attach();
        \add_action('save_post', array($this, 'savePost'), 10, 3);
        \add_action('init', array($this, 'register'));
        \add_action('add_meta_boxes', array($this, 'registerMetaBoxes'));
    }
    
    public function detach()
    {
        parent::detach();
        \remove_action('init', array($this, 'register'));
        \remove_action('save_post', array($this, 'savePost'));
        \remove_action('add_meta_boxes', array($this, 'registerMetaBoxes'));
    }
    
    /**
     * Handler for registration current post-type
     * 
     * @return $this
     */
    public function register()
    {
        if (!post_type_exists($this->getId())) {
            \register_post_type($this->getId(), $this->getConfig());
        }
        
        if (function_exists('add_meta_box')) {
            $this->registerMetaBoxes();
        }
        
        return $this;
    }

    public function registerMetaBoxes()
    {
        foreach ($this->getMetaBoxes() as $MetaBox) {
            $this->registerMetaBox($MetaBox);
        }
    }
    
    public function registerMetaBox($MetaBox)
    {
        \add_meta_box(
            $MetaBox->getId(), 
            $MetaBox->getTitle(), 
            array($MetaBox, 'render'), 
            $this->getId(), 
            $MetaBox->getPosition(), 
            $MetaBox->getPriority()
        );
    }
    
    public function getMetaBoxes()
    {
        return $this->MetaBoxes;
    }
    
    public function addMetaBox(\WPObjects\PostType\MetaBox $MetaBox)
    {
        $this->MetaBoxes[] = $MetaBox;
        
        return $this;
    }
    
    /**
     * Handler for saving posts of current post-type
     * Processing meta attributes saving
     * 
     * @global \WP_Post $_POST
     * @param int $post_id
     * @param \WP_Post $post
     * @param boolean $update creation or update action
     * 
     * @return $this
     */
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
        
        $Post = $this->createModel($post);
        
        $metas = array();
        foreach ($this->getMetaBoxes() as $MetaBox) {
            $metas = array_merge($metas, $MetaBox->processing($Post, $_POST));
        }
        
        foreach ($metas as $attr => $value) {
            $Post->setMeta($attr, self::sanitizeValue($value));
        }
        
        $Post->saveMetas();
        return $this;
    }
    
    /**
     * Update post-type settings in database
     * 
     * @return $this
     */
    public function updateSettings()
    {
        $settings = $this->getSettings();
        if (count($settings)) {
            update_option($this->getSettingsKey(), $this->getSettings());
        } else {
            delete_option($this->getSettingsKey());
        }
        
        return $this;
    }
    
    /**
     * Apply current post-type settings from database
     * 
     * @return $this
     */
    public function initSettings()
    {
        $setting = get_option($this->getSettingsKey(), array());
        $config = $this->getConfig();
        $this->setConfig(array_merge($config, $setting));
        
        return $this;
    }
    
    /**
     * Return current post-type settings
     * 
     * @return array
     */
    public function getSettings()
    {
        $config = $this->getConfig();
        
        $settings = array();
        foreach ($config as $key => $value) {
            if (in_array($key, $this->settings_attributes)) {
                $settings[$key] = $value;
            }
        }
        
        return $settings;
    }
    
    /**
     * Return target current post-type settings
     * 
     * @param string $key
     * @return mixed 
     */
    public function getSetting($key)
    {
        $settings = $this->getSettings();
        
        if (isset($settings[$key])) {
            return $settings[$key];
        }
        
        return null;
    }
    
    /**
     * Set value in to current post-type settings
     * 
     * @param string $key
     * @param string|int|array|boolean $value
     * 
     * @return $this
     */
    public function setSetting($key, $value)
    {
        if (!in_array($key, $this->settings_attributes)) {
            throw new \Exception('Undefined post-type setting attribute');
        }
        
        $config = $this->getConfig();
        if ($value) {
            $config[$key] = $this->sanitizeValue($value);
        } else {
            unset($config[$key]);
        }
        
        $this->setConfig($config);
        
        return $this;
    }
    
    /**
     * Set rewrite slug in url's for posts pages of current post-type
     * 
     * @param string $string
     * @return $this
     * @throws \Exception
     */
    public function setRewriteSlug($string)
    {
        if (!is_string($string)) {
            throw new \Exception('Incorrect slug type, must be string.');
        }
        
        $config = $this->getConfig();
        if (!isset($config['rewrite'])) {
            $config['rewrite'] = array();
        }
        
        if ($string) {
            $config['rewrite']['slug'] = $this->sanitizeValue($string);
        } else {
            unset($config['rewrite']);
        }
        
        $this->setConfig($config);
        
        return $this;
    }
    
    /**
     * Return current rewrite slug in url's for posts pages of current post-type
     * 
     * @return string
     */
    public function getRewriteSlug()
    {
        $config = $this->getConfig();
        if (isset($config['rewrite']) && isset($config['rewrite']['slug'])) {
            return $config['rewrite']['slug'];
        }
        
        return $this->getId();
    }
    
    /**
     * Generate and return WordPress options key for settings of current post-type.
     * 
     * @return string
     */
    public function getSettingsKey()
    {
        return $this->settings_prefix . $this->getId() .'_settings';
    }
    
    /**
     * Sanitize value or array of values, and return them.
     * 
     * @param string|int|array $values
     * @return string|int|array
     */
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
            
            return $values;
        } else {
            return \sanitize_text_field($values);
        }
    }
    
    /**
     * Set identity for WordPress post-type and type of model.
     * 
     * @param type $int
     * @return $this
     */
    public function setId($int)
    {
        $this->id = $int;
        
        return $this;
    }
    
    /**
     * Return identity for WordPress post-type and type of model.
     * 
     * @return type
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Return name of current post-type
     * 
     * @return string
     */
    public function getName()
    {
        $config = $this->getConfig();
        $labels = isset($config['labels']) ? $config['labels'] : array();
        $name = isset($labels['name']) ? $labels['name'] : ucfirst($this->id);
        return $name;
    }
    
    public function getMenuIcon()
    {
        $config = $this->getConfig();
        if (isset($config['menu_icon'])) {
            return $config['menu_icon'];
        }
        
        return null;
    }
    
    public function getLabels($name = null)
    {
        $config = $this->getConfig();
        
        $labels = isset($config['labels']) ? $config['labels'] : array();
        if (is_null($name)) {
            return $labels;
        }
        
        return isset($labels[$name]) ? $labels[$name] : '';
    }
    
    /**
     * Return default attributes of current post-type typical models
     * @return type
     */
    public function getDefaultAttrs()
    {
        return $this->defaults_attrs;
    }
    
    /**
     * Return post meta attributes for current post-type posts
     * 
     * @return array
     */
    public function getRegisterMetas()
    {
        return array_merge($this->register_metas, $this->getQualifiersAttrsNames());
    }
    
    /**
     * Set WordPress post-type config
     * @param type $config
     * @return $this
     */
    public function setConfig($config)
    {
        $this->config = $config;
        
        return $this;
    }
    
    /**
     * Return WordPress post-type config
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
    
    public function getAddNewLink()
    {
        return admin_url('post-new.php?post_type=' . $this->getId());
    }
}

