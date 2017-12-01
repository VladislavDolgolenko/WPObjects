<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\LessCompiler;

use WPObjects\EventManager\ListenerInterface;

class Processing implements 
    ListenerInterface,
    \WPObjects\Service\NamespaceInterface
{
    protected $namespace = 'wpobjects_';
    
    protected $Factory;
    
    protected $WPless = null;
    
    public function attach()
    {
        \add_action( 'init', array( $this, 'initCompeleHandler' ) );
        \add_action('wp_enqueue_scripts', array($this, 'enqueueColorsVariables'));
        \add_action('wp_enqueue_scripts', array($this, 'chackDebag'));
        \add_action( $this->getNamespace() . 'less_vars', array($this, 'getLessParams'));
        \add_action( $this->getNamespace() . 'wp_less_cache_path', array($this, 'getCssCachePath'));
        \add_action('customize_register', array($this, 'registerCustomizeDefaultColors'), 100);
    }
    
    public function detach()
    {
        ;
    }
    
    public function initCompeleHandler()
    {
        $this->WPless = new WPless($this->getNamespace());
    }
    
    public function enqueueColorsVariables()
    {
        $less_params = $this->getParamsFactory()->query()->getResultAsLessParams();
        \wp_localize_script( 'jquery', 'mdl_color_scheme', $less_params);
    }
    
    public function chackDebag()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            delete_option( $this->getNamespace() .'wp_less_cached_files');
        }
    }
    
    public function registerCustomizeDefaultColors($wp_customize)
    {
        if ($wp_customize->get_panel('mdl__color')) {
            return;
        }
        
        $wp_customize->add_panel( 'mdl__color' , array(
            'title'      => esc_html__( 'Color scheme', 'team' ),
            'priority'   => 30,
        ) ); 

        $groups = $this->getParamsFactory()->query()->getResultGroupped();

        foreach ($groups as $group_name => $colors) {

            $sections_name = 'mdl__section_color' . $group_name;

            $wp_customize->add_section( $sections_name , array(
                'title'      => $group_name,
                'priority'   => 30,
                'description' => esc_html__('The color scheme of the site changes on all pages.', 'team'),
                'panel' => 'mdl__color'
            ) ); 

            foreach ($colors as $key => $params) {

                $setting_name = 'mdl__color_' . $key;

                $wp_customize->add_setting($setting_name, array(
                    'transport' => 'refresh',
                    'default' => $params['default'],
                    'sanitize_callback' => 'esc_attr'
                ));

                $wp_customize->add_control(
                    new \WP_Customize_Color_Control(
                    $wp_customize, $setting_name, array(
                        'label' => $params['label'],
                        'section' => $sections_name,
                        'settings' => $setting_name,
                    ))
                );
            }

        }
    }
    
    public function getCssCachePath($basedir)
    {
        return $basedir;
    }
    
    public function getLessParams($vars)
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