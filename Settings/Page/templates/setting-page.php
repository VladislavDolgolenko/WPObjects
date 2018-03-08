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
                    <?php include($this->getServiceManager()->get('wpobjects_dir_path') . '/View/template-parts/copyright.php'); ?>
                </p>
            </div>
        </div>
        
    </div>
</div>