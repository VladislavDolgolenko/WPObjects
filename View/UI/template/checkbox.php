<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

/* @var $this \WPObjects\View\UI\Checkbox */

if (!isset($empty_value)) {
    $empty_value = " ";
}
?>

<div class="msp-form-group horizont invert-with">

    <label for="<?php echo esc_attr($this->name); ?>"><?php echo esc_html($this->lable); ?></label>
    <div class="msp-input-group">
        <input type="hidden" name="<?php echo esc_attr($this->name); ?>" value="<?php echo $empty_value; ?>" />
        <input type="checkbox" name="<?php echo esc_attr($this->name); ?>" id="<?php echo esc_attr($this->name); ?>" value="1" <?php checked($this->value); ?> />
        <div class="clearfix"></div>
    </div>
    
    <div class="clearfix"></div>
    
</div>