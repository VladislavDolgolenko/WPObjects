<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

/* @var $this \WPObjects\Data\Dashboard\Page */

?>

<div class="msp-bootstrap-wrapper msp-dashboard">
    <div class="container-fluid">
        
        <div class="row dashboard-header">
            <div class="col-lg-8">
                <div class="logo">
                    <img src="<?php echo $this->getAssetsDirUrl() . '/img/logo.png' ?>">
                </div>
                <hgroup>
                    <h1><?php esc_html_e('Database','msp'); ?></h1>
                </hgroup>
            </div>
            <div class="col-lg-4 text-right header-link">
                
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="row main-wrapper row-eq-height">
            <div class="col-lg-2 main-nav">

            </div>
            <div class="col-lg-10 main-content">
                <div class="row">
                    <div class="col-lg-12 table-list-filters">
                        
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                <div class="row row-eq-height">
                    <div class="col-lg-12 table-list">
                        
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

