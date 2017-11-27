<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\View\UI;

abstract class AbstractUI extends \WPObjects\View\View
{
    public function enqueues()
    {
        $AM = $this->getAssetsManager();
        $AM->addGlobalScript('jquery')
           ->addGlobalScript('selectize')
           ->addGlobalScript('font-awesome');
        
        $assets_path = plugin_dir_url(dirname(__FILE__) . '/assets/custom');
        
        $AM->registerStyle('font-awesome', $assets_path . '/' . 'css/library/font-awesome.min.css')
           ->registerStyle('bootstrap-wrapper', $assets_path . '/' . 'css/library/bootstrap-wrapper.css')
           ->registerStyle('selectize', $assets_path . '/' . 'css/library/selectize.css')
           ->registerStyle('form', $assets_path . '/css/forms.css', array('bootstrap-wrapper', 'font-awesome', 'selectize'));
        
        $AM->registerScript('selectize', $assets_path . '/js/library/selectize.js', array('jquery'))
           ->registerScript('selectors', $assets_path . '/js/selectors.js', array());
        
        $AM->enqueueStyle('form')
           ->enqueueScript('selectors');
        
        return $this;
    }
}