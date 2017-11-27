<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

?>

<div class="msp-form-group <?php echo $vertical === false ? 'horizont' : ''; ?>">
    
    <label for="<?php echo esc_attr($date_attr); ?>">
        <?php echo esc_html($lable); ?>
    </label>
    
    <div class="msp-input-group datetime">
        <input 
            type="date" 
            name="<?php echo esc_attr($date_attr); ?>" 
            id="<?php echo esc_attr($date_attr); ?>"  
            value="<?php echo esc_attr($date);?>" 
        />
        <input 
            type="time" 
            name="<?php echo esc_attr($time_attr); ?>" 
            id="<?php echo esc_attr($time_attr); ?>"  
            value="<?php echo esc_attr($time);?>" 
        />
        
        <div class="clearfix"></div>
        
    </div>
    
    <div class="clearfix"></div>
    
</div>