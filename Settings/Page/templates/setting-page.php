<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

/* @var $this \WPObjects\Settings\Page\SettingPage */

$SettingsFactory = $this->getServiceManager()->get('SettingsFactory');
$Groups = $SettingsFactory->getGroups();

$namespace = $this->getAssetsManager()->getNamespace();
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
                    <h1><?php esc_html_e('Settings','msp'); ?></h1>
                </hgroup>
            </div>
            <div class="col-lg-4 text-right header-link">
                
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="row main-wrapper row-eq-height">
            <div class="col-lg-2 main-nav">
                <ul role="tablist">
                    
                    <?php foreach ($Groups as $key => $Group) : ?>
                        <li class="<?php echo $key === 0 ? 'active' : ''; ?>">
                            <a role="tab" data-toggle="tab" aria-controls="<?php echo esc_attr($Group['id']) ?>" href="#<?php echo esc_attr($Group['id']) ?>">
                                <?php echo esc_html($Group['name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                        
                </ul>
            </div>
            <div class="col-lg-10 main-content tab-content">

                <?php foreach ($Groups as $key => $Group) : 
                    $Settings = $SettingsFactory->getByGroupName($Group['name']);
                ?>
                
                <div class="tab-pane <?php echo $key === 0 ? 'active' : ''; ?>" role="tabpanel" id="<?php echo esc_attr($Group['id']) ?>">
                    <form method="POST">
                        <input type="hidden" value="<?php echo esc_attr($namespace); ?>" name="setting_namespace">

                        <?php foreach ($Settings as $Setting) : ?>
                        <div class="form-group">
                            <label><?php echo $Setting->getName(); ?></label>
                            <div class="input-group">
                                <input name="<?php echo esc_attr($Setting->getId()); ?>" 
                                       value="<?php echo esc_attr($Setting->getCurrentValue()); ?>" type="text" class="form-control">
                            </div>
                            <div class="help-block">
                                <?php echo $Setting->getDescription(); ?>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <div class="form-group">
                            <button class="btn btn-success"><?php esc_html_e('Save changes', 'msp'); ?></button>
                        </div>
                    </form>
                </div>
                
                <?php endforeach; ?>
                
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