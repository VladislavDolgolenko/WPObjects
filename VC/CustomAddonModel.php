<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

class CustomAddonModel extends WPObjects\Model\AbstractModel implements 
    WPObjects\EventManager\ListenerInterface,
    WPObjects\View\ViewInterface,
    WPObjects\Service\NamespaceInterface,
    WPObjects\Model\ModelTypeFactoryInterface
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
            'CustomAddonModel' => $this,
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
    
    public function beforeShortcode()
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
            $this->styles[] = $name;
        }
        
        return $this;
    }
    
    public function attachScript($name)
    {
        if (!in_array($name, $this->scripts)) {
            $this->scripts[] = $name;
        }
        
        return $this;
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