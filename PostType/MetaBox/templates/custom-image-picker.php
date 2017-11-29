<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */


$meta_key = '_' . $box['id'];
$attachment_id = get_post_meta( $post->ID, $meta_key, true );
$url_attachment = wp_get_attachment_image_url($attachment_id, 'medium');

?>

<div class="msp-bootstrap-wrapper msp-image-picker msp-form">
        
    <?php if ($url_attachment) { ?>
        <img class="attached-image img-responsive add-image" src="<?php echo $url_attachment; ?>" alt="">
    <?php } else { ?>
        <img class="attached-image img-responsive add-image" style="display: none;" alt="">
    <?php } ?>

    <a href="#" class="add-image" title="<?php esc_attr_e('backgound image', 'msp'); ?>">
        <i class="fa fa-picture-o"></i>
        <?php echo esc_html('Select image from library', 'msp'); ?>
    </a>

    <input type="hidden" class="input-attach-img-id" value="<?php echo esc_attr($attachment_id); ?>" name="<?php echo esc_attr($meta_key); ?>">
    
</div>

