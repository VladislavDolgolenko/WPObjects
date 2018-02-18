<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\VC\Template;

class Model extends \WPObjects\Model\AbstractModel implements
    \WPObjects\EventManager\ListenerInterface,
    \WPObjects\AssetsManager\AssetsManagerInterface,
    \WPObjects\Service\NamespaceInterface
{
    protected $id = null;
    protected $name = null;
    protected $config = null;
    protected $weight = null;
    protected $custom_class = null;
    protected $content = null;
    protected $scripts = array();
    protected $styles = array();
    
    protected $namespace = null;
    
    /**
     * @var \WPObjects\AssetsManager\AssetsManager
     */
    protected $AssetsManager = null;
    
    public function toJSON()
    {
        $data = parent::toJSON();
        $data['id'] = $this->getId();
        $data['name'] = $this->getName();
        
        return $data;
    }
    
    public function attach()
    {
        \add_action('vc_load_default_templates_action', array($this, 'addTemplate'));
        \add_filter('shortcode_atts_vc_row', array($this, 'renderTemplate'), 10, 3);
    }
    
    public function detach()
    {
        \remove_action('vc_load_default_templates_action', array($this, 'addTemplate'));
        \remove_filter('shortcode_atts_vc_row', array($this, 'renderTemplate'), 10, 3);
    }
    
    public function renderTemplate($out, $pairs, $attr)
    {
        $identity_attr = $this->getShortcodeAttrName();
        if (isset($attr[$identity_attr]) && $attr[$identity_attr] == $this->id) {
            $this->enqueues();
        }
        
        return $out;
    }
    
    public function enqueues()
    {
        foreach ($this->scripts as $script_name) {
            $this->getAssetsManager()->enqueueScript($script_name);
        }
        
        foreach ($this->styles as $style_name) {
            $this->getAssetsManager()->enqueueStyle($style_name);
        }
    }
    
    public function addTemplate()
    {
        $template_data = array(
            'name' => isset($this->config['name']) ? $this->config['name'] : null,
            'weight' => isset($this->config['weight']) ? $this->config['weight'] : null,
            'custom_class' => isset($this->config['custom_class']) ? $this->config['custom_class'] : null,
            'content' => $this->getContent(),
        );
        
        vc_add_default_templates( $template_data );
    }
    
    public function getContent()
    {
        $attr = $this->getShortcodeAttrName();
        $replace = "[vc_row $attr=\""  . $this->getId() . '" ';
        $search = '[vc_row';
        $content = str_replace($search, $replace, $this->content);
        return $content;
    }
    
    public function setContent($text)
    {
        $this->content = $text;
        
        return $this;
    }
    
    public function getShortcodeAttrName()
    {
        return $this->getNamespace() . '-template';
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($string)
    {
        $this->id = $string;
        
        return $this;
    }
    
    public function getName()
    {
        if (!$this->name && $this->getId()) {
            $id = $this->getId();
            $this->name = ucfirst( trim( str_replace(array(' ', '-', '_'), ' ', $id) ) );
        }
        
        return $this->name;
    }
    
    public function setName($string)
    {
        $this->name = $string;
        
        return $this;
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
    
    public function setAssetsManager(\WPObjects\AssetsManager\AssetsManager $AM)
    {
        $this->AssetsManager = $AM;
        
        return $this;
    }
    
    /**
     * @return \WPObjects\AssetsManager\AssetsManager 
     */
    public function getAssetsManager()
    {
        return $this->AssetsManager;
    }
    
}