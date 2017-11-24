<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

?>

<div class="msp-form-group 
    <?php echo $vertical === false ? 'horizont' : ''; ?> 
    <?php echo isset($invert_with) && $invert_with === true ? 'invert-with' : ''; ?>
    <?php echo isset($balance_with) && $balance_with === true ? 'balance-with' : ''; ?>
">
    
    <label for="<?php echo esc_attr($meta_attr_name); ?>"><?php echo esc_html($lable); ?></label>
    <div class="msp-input-group">
        <input 
            type="<?php echo esc_attr($type); ?>" 
            name="<?php echo esc_attr($meta_attr_name); ?>" 
            id="<?php echo esc_attr($meta_attr_name); ?>"  
            value="<?php echo esc_attr($value);?>" 
            <?php echo isset($step) && $step ? 'step="$step"' : ''; ?>
        />
        <div class="clearfix"></div>
    </div>
    
    <div class="clearfix"></div>
</div>
