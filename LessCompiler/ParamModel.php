<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\LessCompiler;

class ParamModel extends \WPObjects\Model\AbstractModel implements
    \WPObjects\Service\NamespaceInterface,
    \WPObjects\GoogleFonts\FontsFactoryInterface
{
    protected $id = '';
    protected $label = '';
    protected $default = '';
    protected $type = '';
    protected $namespace = '';
    
    /**
     * @var \WPObjects\Factory\FactoryInterface
     */
    protected $FontsFactory = null;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->label ? $this->label : $this->id;
    }
    
    public function getDefault()
    {
        return $this->default;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function setType($string)
    {
        $this->type = $string;
        
        return $this;
    }
    
    public function getCurrentValue()
    {
        $setting_name = $this->getSettingName();
        return \get_theme_mod($setting_name, $this->default);
    }
    
    public function getSettingName()
    {
        return $this->getNamespace() . $this->getId();
    }
    
    public function setNamespace($string)
    {
        $this->namespace = $string;
        
        return $this;
    }
    
    public function getChoices()
    {
        if ($this->getType() === 'font' && $this->getFontsFactory() ) {
            return $this->getFontsFactory()->query()->getForSelect();
        }
        
        return array();
    }
    
    public function getNamespace()
    {
        return $this->namespace;
    }
    
    public function createControleToWpCustomizer($wp_customize, $sections_name)
    {
        $setting_name = $this->getSettingName();
        $label = $this->getName();
        
        $wp_customize->add_setting($setting_name, array(
            'transport' => 'refresh',
            'default' => $this->getDefault(),
            'sanitize_callback' => 'esc_attr'
        ));
        
        if ($this->getType() === 'text') {

            $wp_customize->add_control($setting_name, array(
                'label' => $label,
                'section' => $sections_name,
                'settings' => $setting_name,
                'type' => 'text'
            ));

        } else if ($this->getType() === 'font') {

            $wp_customize->add_control($setting_name, array(
                'label' => $label,
                'description' => esc_html__('Recommended font', 'tektonthm') . ': ' . $this->getDefault(),
                'section' => $sections_name,
                'settings' => $setting_name,
                'type' => 'select',
                'choices' => $this->getChoices()
            ));

        } else if ($this->getType() === 'select') {

            $wp_customize->add_control($setting_name, array(
                'label' => $label,
                'section' => $sections_name,
                'description' => $this->get('description'),
                'settings' => $setting_name,
                'type' => 'select',
                'choices' => $params['choices']
            ));

        } else if ($this->getType() === 'checkbox') {

            $wp_customize->add_control($setting_name, array(
                'label' => $label,
                'section' => $sections_name,
                'description' => $this->get('description'),
                'settings' => $setting_name,
                'type' => 'checkbox',
            ));

        } else if ($this->getType() === 'image') {

            $wp_customize->add_control(new \WP_Customize_Image_Control($wp_customize, $setting_name, array(
                'setting' => $setting_name,
                'label' => $label,
                'description' => $this->get('description'),
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
        
        return $this;
    }
    
    public function setFontsFactory(\WPObjects\GoogleFonts\FontsFactory $FontsFactory)
    {
        $this->FontsFactory = $FontsFactory;
        
        return $this;
    }
    
    public function getFontsFactory()
    {
        return $this->FontsFactory;
    }
}