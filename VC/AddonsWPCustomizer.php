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
    
    /**
     * @var \WPObjects\VC\CustomAddonModel
     */
    protected $Addons = array();
    
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

        $Addons = $this->getAddons();
        foreach ($Addons as $Addon) {

            $sections_name = $this->getNamespace() . $Addon->getId();
            $group_lable = $Addon->getName();
            $settings = $Addon->getCustomizerSettings();
            $Presets = $Addon->getPresets();
            if (!current($settings)) {
                continue;
            }

            $wp_customize->add_section($sections_name, array(
                'title' => $group_lable,
                'priority' => 30,
                'panel' => $panel_name
            ));
            
            /**
             * Add presets constrol
             */
            if (current($Presets)) {
                $presets_setting_name = $this->getNamespace() . $Addon->getId() . '_preset_constrole';
                $wp_customize->add_setting($presets_setting_name, array(
                    'transport' => 'refresh',
                    'default' => '',
                    'sanitize_callback' => 'esc_attr'
                ));
                $PresetsControle = new \WPObjects\Customizer\Preset\CustomizerControle($wp_customize, $presets_setting_name, array(
                    'label' => esc_html__('lol', 'team'),
                    'settings' => $presets_setting_name,
                    'section'  => $sections_name,
                ), $Presets);
                $Addon->getServiceManager()->inject($PresetsControle);
                $wp_customize->add_control($PresetsControle);
            }

            foreach ($settings as $key => $Setting) {
                $setting_name = $Setting->getSettingName();
                
                if ($key === 0) {
                    $wp_customize->selective_refresh->add_partial( $setting_name, array(
                        'selector' => '.' . $Addon->getWPCustomizerPartialClass(),
                        'container_inclusive' => false,
                    ));
                }

                $Setting->createControleToWpCustomizer($wp_customize, $sections_name);
            }
        }
    }
    
    /**
     * @return \WPObjects\VC\CustomAddonModel
     */
    public function getAddons()
    {
        if (!$this->Addons && $this->getAddonsFactory()) {
            $this->Addons = $this->getAddonsFactory()->query()->getResult();
        }
        
        return $this->Addons;
    }
    
    public function setAddons($Addons)
    {
        $this->Addons = $Addons;
        
        return $this;
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