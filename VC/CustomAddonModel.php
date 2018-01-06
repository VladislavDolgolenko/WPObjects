<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\VC;

class CustomAddonModel extends \WPObjects\Model\AbstractModel implements 
    \WPObjects\EventManager\ListenerInterface,
    \WPObjects\View\ViewInterface,
    \WPObjects\Service\NamespaceInterface,
    \WPObjects\Model\ModelTypeFactoryInterface,
    \WPObjects\VC\Shortcode\ShortcodeInterface
{
    protected $base = null;
    protected $name = null;
    protected $enqueue_styles = array();
    protected $enqueue_scripts = array();
    protected $params = array();
    protected $category = null;
    protected $html_template = array();
    protected $php_class_name = '\WPObjects\VC\Shortcode';
    protected $query_model_type = null;
    protected $less_params = null;
    
    protected $init_settings = array();
    
    /**
     * @var \WPBakeryShortCode
     */
    protected $Shortcode = null;
    
    /**
     * @var \WPObjects\Model\ModelTypeFactory
     */
    protected $ModelTypeFactory = null;
    
    public function attach()
    {
        if (\did_action('plugins_loaded') > 0) {
            \add_action('plugins_loaded', array($this, 'registerHandler'), 30, 0);
        } else {
            $this->registerHandler();
        }
    }
    
    public function detach()
    {
        \remove_action('plugins_loaded', array($this, 'registerHandler'), 30, 0);
    }
    
    public function registerHandler()
    {
        if (!class_exists('WPBMap')) {
            return;
        }
        
        \WPBMap::map($this->getId(), $this->getVCShortcodeConfig());
    }
    
    public function getVCShortcodeConfig()
    {
        $config = array(
            'AddonModel' => $this,
            'base' => $this->getId(),
            'name' => $this->getName(),
            'php_class_name' => $this->php_class_name,
            'category' => $this->category,
            'html_template' => $this->html_template,
            'params' => $this->params,
        );
        
        // If setted main model type for addon, will be added special forms to addon ui editing panel
        if ($this->query_model_type) {
            $ModelType = $this->getModelTypeFactory()->get($this->query_model_type);
            if ($ModelType instanceof \WPObjects\Model\AbstractModelType) {
                $ShorcodeParams = new \WPObjects\VC\ShorcodeParams();
                $config['params'] = $ShorcodeParams->genAllParams($ModelType, $config['params']);
            }
        }
        
        return array_filter($config);
    }
    
    public function enqueues()
    {
        $scripts = apply_filters($this->getNamespace() . '-addon-js-' . $this->getName(), $this->enqueue_scripts);
        foreach ($scripts as $script) {
            \wp_enqueue_script($script);
        }
        
        $styles = apply_filters($this->getNamespace() . '-addon-style-' . $this->getName(), $this->enqueue_styles);
        foreach ($styles as $style) {
            \wp_enqueue_style($style);
        }
    }
    
    public function render()
    {
        $Shortcode = $this->getShortcode();
        if (!$Shortcode) {
            return;
        }
        
        echo $Shortcode->loadTemplate();
    }
    
    public function beforeContent()
    {
        if ( \is_customize_preview() ) {
            echo '<div class="'. $this->getName() . ' ' . $this->getNamespace() . '-vc-shorcode-wp-customize" style="position: relative;"></div>';
        }
    }
    
    /**
     * Callback inject, when visual composer init shortcode 
     * in WPObjects\VC\Shortcode\DefaultShortcode::__construct()
     * 
     * @param \WPBakeryShortCode $Shortcode
     * @return $this
     */
    public function setShortcode(\WPBakeryShortCode $Shortcode)
    {
        $this->Shortcode = $Shortcode;
        
        return $this;
    }
    
    public function getShortcode()
    {
        return $this->Shortcode;
    }
    
    public function attachStyle($name)
    {
        if (!in_array($name, $this->styles)) {
            $this->enqueue_styles[] = $name;
        }
        
        return $this;
    }
    
    public function attachScript($name)
    {
        if (!in_array($name, $this->scripts)) {
            $this->enqueue_scripts[] = $name;
        }
        
        return $this;
    }
    
    public function getEnqueueScriptName()
    {
        return current( $this->getEnqueueScripts() );
    }
    
    public function getEnqueueStyles()
    {
        return $this->enqueue_styles;
    }
    
    public function getEnqueueScripts()
    {
        return $this->enqueue_scripts;
    }
    
    public function getId()
    {
        return $this->base;
    }
    
    public function setId($string)
    {
        $this->base = (string)$string;
        
        return $this;
    }
    
    public function getName()
    {
        if ($this->name) {
            return $this->name;
        }
        
        $name = ucfirst( trim ( str_replace(array('_', '-', '/'), ' ', $this->getId()) ) );
        
        return $name;
    }
    
    public function setName($string)
    {
        $this->name = $string;
        
        return $this;
    }
    
    /**
     * Return settings panel param cofig by name
     * 
     * @param string $param_name
     * @return mixed
     */
    public function getConfigParam($param_name)
    {
        foreach ($this->params as $param) {
            if ($param['param_name'] === $param_name) {
                return $param;
            }
        }

        return array();
    }
    
    /**
     * Custom setting from shortcode panel editing
     * 
     * @return array
     */
    public function getShortcodeSettings()
    {
        if (!function_exists('vc_map_get_attributes')) {
            return $this->init_settings;
        }
        
        if (is_null($this->init_settings)) {
            $this->init_settings = \vc_map_get_attributes($this->getShortcode()->getShortcode(), $this->getShortcode()->getAtts());
        }
        
        return $this->init_settings;
    }
    
    public function setTemplatePath($string)
    {
        $this->html_template = $string;
        
        return $this;
    }
    
    public function getTemplatePath()
    {
        return $this->html_template;
    }
    
    public function setModelTypeFactory(\WPObjects\Model\ModelTypeFactory $ModelTypeFactory)
    {
        $this->ModelTypeFactory = $ModelTypeFactory;
        
        return $this;
    }
    
    /**
     * @return \WPObjects\Model\ModelTypeFactory
     */
    public function getModelTypeFactory()
    {
        return $this->ModelTypeFactory;
    }
    
    public function setNamespace($string)
    {
        $this->namespace = $string;
        
        return $this;
    }
    
    public function getNamespace()
    {
        return $this->namespace;
    }
}