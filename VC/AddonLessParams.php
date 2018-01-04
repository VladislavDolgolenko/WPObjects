<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\VC;

class AddonLessParams
{
    public function loadScripts()
    {
        $shortcode_dir = $this->getName();
        
        $js_file_name = MSP_PATH . '/includes/vc/shortcodes/'. $shortcode_dir .'/js.js';
        if (file_exists($js_file_name)) {
            \wp_register_script($this->getScriptName(), MSP_PATH_URL . '/includes/vc/shortcodes/' . $shortcode_dir . '/js.js', $this->getJSDeps(), msp__v(), 'all' );
        }
        
        $less_file_name = MSP_PATH . '/includes/vc/shortcodes/'. $shortcode_dir .'/style.less';
        if (file_exists($less_file_name)) {
            \wp_register_style($this->getScriptName(), MSP_PATH_URL . '/includes/vc/shortcodes/' . $shortcode_dir . '/style.less', $this->getLessDeps(), msp__v());
            add_filter('mdl__less_vars', array($this, 'renderLess'), 20, 2);
            add_filter('mdl__less_vars', array($this, 'renderLessVariables'), 30, 2);
        }
    }
    
    public function renderLess($vars, $handle)
    {
        if ($handle !== $this->getScriptName()) {
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

        wp_localize_script($this->getScriptName(), $this->getName(), $vars);

        return $vars;
    }
    
    public function renderLessVariables($vars, $handle)
    {
        if ($handle !== $this->getScriptName()) {
            return $vars;
        }

        $less_variables = isset($this->config['register_less_vars']) ? $this->config['register_less_vars'] : array();
        if (!is_array($less_variables) || !count($less_variables)) {
            return $vars;
        }
        
        $settings = $this->getShortcodeSettings();
        foreach ($less_variables as $var_name) {
            if (!isset($settings[$var_name]) || !$settings[$var_name]) {
                $vars[$var_name] = 'none';
                continue;
            }

            $config = $this->getParamConfig($var_name);
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
    
    /**
     * Custom setting from shortcode panel editing
     * @return array
     */
    public function getShortcodeSettings()
    {
        if (is_null($this->settings)) {
            $this->settings = vc_map_get_attributes($this->getShortcode()->getShortcode(), $this->getShortcode()->getAtts());
        }
        
        return $this->settings;
    }
    
    /**
     * Params from shortcode declaration config
     * @param string $param_name
     * @return mixed
     */
    public function getParamConfig($param_name)
    {
        foreach ($this->config['params'] as $param) {
            if ($param['param_name'] === $param_name) {
                return $param;
            }
        }

        return array();
    }
}