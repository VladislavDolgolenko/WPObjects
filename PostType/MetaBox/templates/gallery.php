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

/* @var $this \WPObjects\PostType\MetaBox\Gallery */

$post = $this->getPostModel();

$attachments = $post->getMeta('_gallery_attachments_id');
if (!is_array($attachments) || count($attachments) === 0) {
    $attachments = array();
}

?>

<script type="text/html" id="tmp-msp-ui-gallery-element">
    <div class="image">
        <input type="hidden" name="_gallery_attachments_id[]" value="<%= attach_id %>">
        <img src="<%= img_url %>" width="100%" alt="">

        <div class="actions-panel">
            <div class="button">
                <i class="fa fa-times cursor-move fa fa-arrows"></i>
            </div>

            <button class="button delete-attach">
                <i class="fa fa-times cursor-pointer"></i>
            </button>
        </div>

        <div class="clearfix"></div>
    </div>
</script>

<div class="msp-bootstrap-wrapper msp-form msp-mb-gallery" id="msp-ui-gallery">
    
    <div class="row attached-images">
        <?php foreach ($attachments as $attach) { 
        $url_attachment = wp_get_attachment_image_url($attach, 'medium');    
        ?>
        <div class="col-sm-2 col-md-4 col-lg-2 image-wrapper">
            <div class="image">
                <input type="hidden" name="_gallery_attachments_id[]" value="<?php echo esc_attr($attach); ?>">
                <img src="<?php echo esc_url($url_attachment); ?>" width="100%" alt="">

                <div class="actions-panel">
                    <div class="button">
                        <i class="fa fa-times cursor-move fa fa-arrows"></i>
                    </div>

                    <button class="button delete-attach">
                        <i class="fa fa-times cursor-pointer"></i>
                    </button>
                </div>
                
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php } ?>
    </div>
    
    <button class="button button-default button-width add-attachments" title="<?php esc_html_e('add images to gallery', 'msp');?>">
        <i class="fa fa-plus"></i> <?php esc_html_e('add images to gallery', 'msp');?>
    </button>
    
    <div class="clearfix"></div>
</div>