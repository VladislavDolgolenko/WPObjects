<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

?>

<div class="msp-bootstrap-wrapper msp-form custom-attrs">
    
    <div class="elements">
        <?php foreach ($this->getElements() as $element) { ?>
            <article class="ui-state-default attr">
                <input type="hidden" name="social_counter[]" value="1">

                <i class="fa fa-arrows cursor-move"></i>
                <i class="fa fa-times delete-feature"></i>

                <div class="row">
                    <div class="col-lg-4">
                        <?php $this->getSocialsSelector($element['icon_class']); ?>
                    </div>
                    <div class="col-lg-8">
                        <div class="msp-input-group">
                        <input type="url" 
                               value="<?php echo esc_attr($element['link']); ?>" 
                               placeholder="<?php echo esc_attr('https://www.facebook.com');?>" 
                               name="<?php echo esc_attr('social_link');?>[]">
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
    
        <input type="hidden" name="social_counter[]" value="1">

        <i class="fa fa-arrows cursor-move"></i>
        <i class="fa fa-times delete-feature"></i>

        <div class="row">
            <div class="col-lg-4">
                <?php $this->getSocialsSelector(); ?>
            </div>
            <div class="col-lg-8">
                <div class="msp-input-group">
                <input type="url" 
                       value="" 
                       placeholder="<?php echo esc_attr('https://www.facebook.com');?>" 
                       name="social_link[]">
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

    </script>
    
</div>

