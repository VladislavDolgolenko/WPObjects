<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\Settings\Page;

class SettingPage extends \WPObjects\Page\AdminPage
{
    public function __construct()
    {
        $this->setMenuName(__( 'Settings', 'msp' ));
        $this->setTitle(__( 'Settings', 'msp' ));
        $this->setPermission('manage_options');
        $this->setId('settings');
        $this->setMenuPosition(30);
        
        $this->setTemplatePath(dirname(__FILE__) . '/templates/setting-page.php');
    }
    
    public function enqueues()
    {
        $AM = $this->getAssetsManager();
        $AM->enqueueStyle('database');
    }
    
    /**
     * @return \WPObjects\Settings\Model
     */
    public function getSettings()
    {
        $Factory = $this->getServiceManager()->get('SettingsFactory');
        return $Factory->query()->getResult();
    }
}