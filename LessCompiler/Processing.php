<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\LessCompiler;

use WPObjects\EventManager\ListenerInterface;

class Processing implements 
    ListenerInterface,
    \WPObjects\Service\NamespaceInterface,
    LessParamsInterface,
    WPlessInterface
{
    protected $namespace = 'wpobjects_';
    
    protected $Factory;
    
    /**
     * @var \WPObjects\LessCompiler\WPless
     */
    protected $WPless = null;
    
    public function attach()
    {
        if (!$this->getWPLess()) {
            return;
        }
        
        \add_action('wp_enqueue_scripts', array($this, 'enqueueColorsVariables'));
        \add_action('wp_enqueue_scripts', array($this, 'chackDebag'));
        \add_filter( $this->getWPLess()->getCompileFilterName(), array($this, 'getLessParams'));
        \add_filter( $this->getNamespace() . 'wp_less_cache_path', array($this, 'getCssCachePath'));
        \add_action('customize_register', array($this, 'registerCustomizePanel'), 100);
    }
    
    public function detach()
    {
        \remove_action('wp_enqueue_scripts', array($this, 'enqueueColorsVariables'));
        \remove_action('wp_enqueue_scripts', array($this, 'chackDebag'));
        \remove_filter( $this->getWPLess()->getCompileFilterName(), array($this, 'getLessParams'));
        \remove_filter( $this->getNamespace() . 'wp_less_cache_path', array($this, 'getCssCachePath'));
        \remove_action('customize_register', array($this, 'registerCustomizePanel'), 100);
    }
    
    public function enqueueColorsVariables()
    {
        $less_params = $this->getParamsFactory()->query()->getResultAsLessParams();
        \wp_localize_script( 'jquery', $this->getNamespace() . '_color_scheme', $less_params);
    }
    
    public function chackDebag()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            delete_option( $this->getNamespace() .'wp_less_cached_files');
        }
    }
    
    public function registerCustomizePanel($wp_customize)
    {
        $panel_name = $this->getNamespace() . '__color';
        if (!$wp_customize->get_panel($panel_name)) {
            $wp_customize->add_panel($panel_name , array(
                'title' => $this->getNamespace() . ' ' . esc_html__( 'customizing', 'team' ),
                'priority' => 30,
            )); 
        }

        $groups = $this->getParamsFactory()->query()->getResultGroupped();
        foreach ($groups as $group_name => $params) {
            
            $sections_name = $this->getNamespace() . '__section_color' . $group_name;
            $wp_customize->add_section($sections_name, array(
                'title' => $group_name,
                'priority' => 30,
                'panel' => $panel_name
            )); 
            
            /* @var $param \WPObjects\LessCompiler\ParamModel */
            foreach ($params as $param) {
                $param->createControleToWpCustomizer($wp_customize, $sections_name);
            }
            
        }
    }
    
    public function getCssCachePath($basedir)
    {
        return $basedir;
    }
    
    public function getLessParams($vars, $handle = null)
    {
        $less_params = $this->getParamsFactory()->query()->getResultAsLessParams();
        return array_merge($vars, $less_params);
    }
    
    public function setParamsFactory(\WPObjects\LessCompiler\ParamsFactory $Factory)
    {
        $this->Factory = $Factory;
    }
    
    /**
     * @return \WPObjects\LessCompiler\ParamsFactory
     */
    public function getParamsFactory()
    {
        return $this->Factory;
    }
    
    /**
     * @return \WPObjects\LessCompiler\WPless
     */
    public function getWPLess()
    {
        return $this->WPless;
    }
    
    public function setWPLess(\WPObjects\LessCompiler\WPless $WPless)
    {
        $this->WPless = $WPless;
        
        return $this;
    }
    
    public function setNamespace($namespace)
    {
        if (!is_string($namespace) || strlen($namespace) < 2) {
            throw new \Exception('Incorrect namespace setted fot LessCompiler Processing');
        }
        
        $this->namespace = $namespace;
        
        return;
    }
    
    public function getNamespace()
    {
        return $this->namespace;
    }
}