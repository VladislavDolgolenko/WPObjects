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

/* @var $this \WPObjects\PostType\MetaBox\PageAsArchive */

?>

<div class="msp-bootstrap-wrapper msp-image-picker msp-form">
    
    <?php $this->renderSelector('_page_as_archive', __('Page as archive for:', 'msp'), $this->getPostTypesForSelect()); ?>
    
    <p class="help-block">
        <?php esc_html_e('Setup this page as archive page for selected post-type.', 'msp') ?>
    </p>
    
</div>