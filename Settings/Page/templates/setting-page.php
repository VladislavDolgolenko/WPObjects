<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

/* @var $this \WPObjects\Settings\Page\SettingPage */

$Settings = $this->getSettings();
?>

<div class="msp-bootstrap-wrapper msp-dashboard">
    <div class="container-fluid">
        
        <div class="row dashboard-header">
            <div class="col-lg-8">
                <div class="logo">
                    <img src="<?php echo $this->getAssetsDirUrl() . '/img/logo.png' ?>">
                </div>
                <hgroup>
                    <h1><?php esc_html_e('Settings','msp'); ?></h1>
                </hgroup>
            </div>
            <div class="col-lg-4 text-right header-link">
                
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="row main-wrapper row-eq-height">
            <div class="col-lg-12 main-content">
                
                <?php foreach ($Settings as $Setting) : ?>
                
                <div class="form-group">
                    <label><?php echo $Setting->getName(); ?></label>
                    <div class="input-group">
                        <input name="<?php echo $Setting->getId(); ?>" type="text" class="form-control">
                    </div>
                </div>
                
                <?php endforeach; ?>
                
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>