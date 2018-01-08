<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\VC;

class AddonsWPCustomizer implements
    \WPObjects\EventManager\ListenerInterface,
    \WPObjects\Service\NamespaceInterface
{
    protected $namespace = '';
    
    /**
     * @var \WPObjects\Factory\FactoryInterface
     */
    protected $AddonsFactory = null;
    
    public function attach()
    {
        \add_action('customize_register', array($this, 'addPanel'));
    }
    
    public function detach()
    {
        \remove_action('customize_register', array($this, 'addPanel'));
    }
    
    public function addPanel($wp_customize)
    {
        $panel_name =  $this->getNamespace() . 'addons-customizing';
        
        $wp_customize->add_panel($panel_name, array(
            'title' => esc_html__('Addons customizing', 'msp'),
            'priority' => 30,
        ));

        !!?@3f3
        $google_fonts = \TEKTONTHM\getGoogleFontsListForSelect();
        
        $Addons = $this->getAddons();

        foreach ($Addons as $Addon) {

            $sections_name = $this->getNamespace() . $Addon->getId();
            $group_lable = $Addon->getName();
            $settings = $Addon->getCustomizerSettings();

            $wp_customize->add_section($sections_name, array(
                'title' => $group_lable,
                'priority' => 30,
                'panel' => $panel_name
            ));

            foreach ($settings as $key => $Setting) {
                $setting_name = $Setting->getSettingName();
                $default = $Setting->get('default');
                $label = $Setting->getName();

                $wp_customize->add_setting($setting_name, array(
                    'transport' => 'refresh',
                    'default' => $default ? $default : '',
                    'sanitize_callback' => 'esc_attr'
                ));
                
                if ($key === 0) {
                    $wp_customize->selective_refresh->add_partial( $setting_name, array(
                        'selector' => '.' . $Setting->getId(),
                        'container_inclusive' => false,
                    ));
                }

                if ($params['type'] === 'text') {

                    $wp_customize->add_control($setting_name, array(
                        'label' => $label,
                        'section' => $sections_name,
                        'settings' => $setting_name,
                        'type' => 'text'
                    ));
                    
                } else if ($params['type'] === 'font') {

                    $wp_customize->add_control($setting_name, array(
                        'label' => $label,
                        'description' => esc_html__('Recommended font', 'tektonthm') . ': ' . $params['default'],
                        'section' => $sections_name,
                        'settings' => $setting_name,
                        'type' => 'select',
                        'choices' => $google_fonts
                    ));
                    
                } else if ($params['type'] === 'select') {

                    $wp_customize->add_control($setting_name, array(
                        'label' => $label,
                        'section' => $sections_name,
                        'description' => isset($params['description']) ? $params['description'] : null,
                        'settings' => $setting_name,
                        'type' => 'select',
                        'choices' => $params['choices']
                    ));
                    
                } else if ($params['type'] === 'checkbox') {

                    $wp_customize->add_control($setting_name, array(
                        'label' => $label,
                        'section' => $sections_name,
                        'description' => isset($params['description']) ? $params['description'] : null,
                        'settings' => $setting_name,
                        'type' => 'checkbox',
                    ));
                    
                } else if ($params['type'] === 'image') {

                    $wp_customize->add_control(new \WP_Customize_Image_Control($wp_customize, $setting_name, array(
                        'setting' => $setting_name,
                        'label' => $label,
                        'description' => isset($params['description']) ? $params['description'] : null,
                        'section' => $sections_name
                    )));
                    
                } else {
                    
                    $wp_customize->add_control( new \WP_Customize_Color_Control(
                        $wp_customize, 
                        $setting_name, 
                        array(
                            'label' => $label,
                            'section' => $sections_name,
                            'settings' => $setting_name,
                        )
                    ));
                    
                }
            }
        }
    }
    
    /**
     * @return \WPObjects\VC\CustomAddonModel
     */
    public function getAddons()
    {
        $this->getAddonsFactory()->query()->getResult();
    }
    
    public function setAddonsFactory(\WPObjects\Factory\FactoryInterface $Factory)
    {
        $this->AddonsFactory = $Factory;
        
        return $this;
    }
    
    /**
     * @return \WPObjects\Factory\FactoryInterface
     */
    public function getAddonsFactory()
    {
        return $this->AddonsFactory;
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