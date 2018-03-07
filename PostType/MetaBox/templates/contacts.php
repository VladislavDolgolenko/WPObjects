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

<div class="msp-bootstrap-wrapper msp-form custom-attrs">
    
    <div class="elements">
        <?php foreach ($this->getElements() as $element) { ?>
            <article class="ui-state-default attr">
                <input type="hidden" name="contact_counter[]" value="1">

                <i class="fa fa-arrows cursor-move"></i>
                <i class="fa fa-times delete-feature"></i>

                <div class="row">
                    <div class="col-lg-4">
                        <?php $this->getSocialsSelector($element['icon_class']); ?>
                    </div>
                    <div class="col-lg-4">
                        <div class="msp-input-group">
                        <input type="text" 
                               value="<?php echo esc_attr($element['name']); ?>" 
                               placeholder="<?php echo esc_attr('Phone');?>" 
                               name="<?php echo esc_attr('contact_name');?>[]">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="msp-input-group">
                        <input type="text" 
                               value="<?php echo esc_attr($element['link']); ?>" 
                               placeholder="<?php echo esc_attr('+3 77 777 77 77');?>" 
                               name="<?php echo esc_attr('contact_link');?>[]">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </article>
        <?php } ?>
    </div>
    
    <button class="button button-width button-default create-element">
        <i class="fa fa-plus"></i>
            <?php esc_html_e('add more socials', 'block');?>
    </button>
    
    <div class="clearfix"></div>
    
    <script type="template/text" class="souce-attr">
    
        <input type="hidden" name="contact_counter[]" value="1">

        <i class="fa fa-arrows cursor-move"></i>
        <i class="fa fa-times delete-feature"></i>

        <div class="row">
            <div class="col-lg-4">
                <?php $this->getSocialsSelector(); ?>
            </div>
            <div class="col-lg-4">
                <div class="msp-input-group">
                <input type="text" 
                       value="<?php echo esc_attr($element['name']); ?>" 
                       placeholder="<?php echo esc_attr('Phone');?>" 
                       name="<?php echo esc_attr('contact_name');?>[]">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="msp-input-group">
                <input type="text" 
                       value="" 
                       placeholder="<?php echo esc_attr('https://www.facebook.com');?>" 
                       name="contact_link[]">
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

    </script>
    
</div>

