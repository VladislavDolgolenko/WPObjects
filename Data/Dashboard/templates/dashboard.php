<?php

/**
 * @encoding     UTF-8
 * @package      WPObjects
 * @link         https://github.com/VladislavDolgolenko/WPObjects
 * @copyright    Copyright (C) 2018 Vladislav Dolgolenko
 * @license      MIT License
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      <help@vladislavdolgolenko.com>
 */

/* @var $this \WPObjects\Data\Dashboard\Page */

$wpobjects_url = $this->getServiceManager()->get('wpobjects_dir_url');

?>

<div class="msp-bootstrap-wrapper msp-dashboard">
    <div class="container-fluid">
        
        <div class="row dashboard-header">
            <div class="col-lg-8">
                <div class="logo">
                    <img src="<?php echo $wpobjects_url . '/assets/img/logo.png' ?>">
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
        
        <div class="row">
            <div class="col-xs-12 text-right">
                <p class="wpobjects-copirytes">
                    Build on 
                    <a target="_blank" href="https://github.com/VladislavDolgolenko/WPObjects">\WPObjects</a> 
                    v<?php echo esc_html($this->getServiceManager()->get('wpobjects_build'));?>
                </p>
            </div>
        </div>
    </div>
</div>

