<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\VC;

class AddonLessParams implements 
    \WPObjects\EventManager\ListenerInterface,
    \WPObjects\VC\AddonInterface
{
    /**
     * @var \WPObjects\VC\CustomAddonModel
     */
    protected $Addon = null;
    
    public function attach()
    {
        \add_filter('mdl__less_vars', array($this, 'renderLess'), 20, 2);
        \add_filter('mdl__less_vars', array($this, 'renderLessVariables'), 30, 2);
    }
    
    public function detach()
    {
        \remove_filter('mdl__less_vars', array($this, 'renderLess'), 20, 2);
        \remove_filter('mdl__less_vars', array($this, 'renderLessVariables'), 30, 2);
    }
    
    /**
     * Colors params to less params
     * 
     * @param type $vars
     * @param type $handle
     * @return type
     */
    public function renderLess($vars, $handle)
    {
        if ( in_array($handle, $this->getAddon()->getEnqueueStyles()) ) {
            return $vars;
        }
        
        $settings = $this->getShortcodeSettings();
        
        $default_theme_variables = $this->getParamsFactory()->query(array(
            'group' => 'base_scheme'
        ))->getResultAsThemeModeDefault();
        $colors = self::getColorsGlobalCustomizing($this->getName());
        foreach ($colors as $name => $color) {
            
            if (isset($vars[$name]) && array_key_exists($name, $default_theme_variables)) {
                $value = isset($settings[$name]) && $settings[$name] != "" ? $settings[$name] : $vars[$name];
            } else {
                $value = isset($settings[$name]) && $settings[$name] != "" ? $settings[$name] : $color['default'];
            }
            
            $vars[$name] = $value;
        }

        // If have script, added all vars to using in js
        \wp_localize_script($this->getAddon()->getEnqueueScriptName(), $this->getAddon()->getName(), $vars);

        return $vars;
    }
    
    /**
     * Settings to less params
     * 
     * @param type $vars
     * @param type $handle
     * @return string
     */
    public function renderLessVariables($vars, $handle)
    {
        if ( in_array($handle, $this->getAddon()->getEnqueueStyles()) ) {
            return $vars;
        }

        $less_variables = $this->getAddon()->get('register_less_vars');
        if (!is_array($less_variables) || !count($less_variables)) {
            return $vars;
        }
        
        $settings = $this->getAddon()->getShortcodeSettings();
        foreach ($less_variables as $var_name) {
            if (!isset($settings[$var_name]) || !$settings[$var_name]) {
                $vars[$var_name] = 'none';
                continue;
            }

            $config = $this->getAddon()->getConfigParam($var_name);
            if (!isset($config['type'])) {
                continue;
            }

            if ($config['type']  !== 'attach_image') {
                $vars[$var_name] = $settings[$var_name];
            } else {
                $vars[$var_name] = "'" . wp_get_attachment_image_url($settings[$var_name], 'full') . "'";
            }
        }

        return $vars;
    }
    
    public function setAddon(\WPObjects\VC\CustomAddonModel $Addon)
    {
        $this->Addon = $Addon;
        
        return $this;
    }
    
    /**
     * @retrun \WPObjects\VC\CustomAddonModel
     */
    public function getAddon()
    {
        return $this->Addon;
    }
}