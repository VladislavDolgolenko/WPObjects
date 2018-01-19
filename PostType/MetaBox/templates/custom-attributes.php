<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

$elements = $this->getElements();

?>

<div class="msp-bootstrap-wrapper msp-form custom-attrs">
    
    <div class="elements">
        <?php foreach ($elements as $element) { ?>
            <article class="ui-state-default attr">
                <input type="hidden" name="attrs_counter[]" value="1">

                <i class="fa fa-arrows cursor-move"></i>
                <i class="fa fa-times delete-feature"></i>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="msp-input-group">
                        <input 
                            type="text" 
                            value="<?php echo isset($element['name']) ? esc_attr($element['name']) : ''; ?>" 
                            placeholder="<?php esc_attr_e('Attribute name', 'block');?>" 
                            name="<?php echo esc_attr('attr_name');?>[]"
                        >
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="msp-input-group">
                        <input 
                            type="text" 
                            value="<?php echo isset($element['text']) ? esc_attr($element['text']) : ''; ?>" 
                            placeholder="<?php esc_attr_e('Attribute details', 'block');?>" 
                            name="<?php echo esc_attr('attr_text');?>[]"
                        >
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </article>
        <?php } ?>
    </div>
    
    <button class="button button-width button-default create-element">
        <i class="fa fa-plus"></i>
            <?php esc_html_e('add more attributes', 'block');?>
    </button>
    
    <div class="clearfix"></div>
    
    <script type="template/text" class="souce-attr">
    
        <input type="hidden" name="attrs_counter[]" value="1">

        <i class="fa fa-arrows cursor-move"></i>
        <i class="fa fa-times delete-feature"></i>

        <div class="row">
            <div class="col-lg-6">
                <div class="msp-input-group">
                <input 
                    type="text" 
                    value="" 
                    placeholder="<?php esc_attr_e('Attribute name', 'block');?>" 
                    name="<?php echo esc_attr('attr_name');?>[]"
                >
                </div>
            </div>
            <div class="col-lg-6">
                <div class="msp-input-group">
                <input 
                    type="text" 
                    value="" 
                    placeholder="<?php esc_attr_e('Attribute details', 'block');?>" 
                    name="<?php echo esc_attr('attr_text');?>[]"
                >
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

    </script>
    
</div>
