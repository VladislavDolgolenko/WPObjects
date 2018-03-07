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

?>

<div class="msp-form-group 
    <?php echo $this->vertical === false ? 'horizont' : ''; ?> 
    <?php echo isset($this->invert_with) && $this->invert_with === true ? 'invert-with' : ''; ?>
    <?php echo isset($this->balance_with) && $this->balance_with === true ? 'balance-with' : ''; ?>
">
    
    <label for="<?php echo esc_attr($this->name); ?>">
        <?php echo esc_html($this->lable); ?>
    </label>
    <div class="msp-input-group">
        <input 
            type="<?php echo esc_attr($this->type); ?>" 
            name="<?php echo esc_attr($this->name); ?>" 
            id="<?php echo esc_attr($this->name); ?>"  
            value="<?php echo esc_attr($this->value);?>" 
            <?php echo isset($this->step) && $this->step ? 'step="$step"' : ''; ?>
        />
        <div class="clearfix"></div>
    </div>
    
    <div class="clearfix"></div>
</div>
