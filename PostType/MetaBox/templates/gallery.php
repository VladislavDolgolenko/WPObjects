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
    <div class="form-group">
        <div class="input-group-addon">
            <div class="p-sm">
                <i class="fa fa-times pull-left cursor-move fa fa-arrows x3"></i>
                <i class="fa fa-times pull-right delete-attach x3 cursor-pointer"></i>
                <div class="clearfix"></div>
            </div>
            <div class="m-sm text-center">
                <input type="hidden" name="_gallery_attachments_id[]" value="<%= attach_id %>">
                <img src="<%= img_url %>" width="100%" alt="">
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</script>

<div class="msp-bootstrap-wrapper msp-form" id="msp-ui-gallery">
    
    <div class="msp-form-group">
        <button class="button add-attachments m-b-md" title="<?php esc_html_e('add images to gallery', 'block');?>">
            <i class="fa fa-plus"></i> <?php esc_html_e('add images to gallery', 'block');?>
        </button>
    </div>
    
    <div class="row attached-images">
        <?php foreach ($attachments as $attach) { 
        $url_attachment = wp_get_attachment_image_url($attach, 'thumbnail');    
        ?>
        <article class="col-sm-2 col-md-4 col-lg-2">
            <div class="form-group">
                <div class="input-group-addon">
                    <div class="p-sm">
                        <i class="fa fa-times pull-left cursor-move fa fa-arrows x3"></i>
                        <i class="fa fa-times pull-right delete-attach x3 cursor-pointer"></i>
                        <div class="clearfix"></div>
                    </div>
                    <div class="m-sm text-center">
                        <input type="hidden" name="_gallery_attachments_id[]" value="<?php echo esc_attr($attach); ?>">
                        <img src="<?php echo esc_url($url_attachment); ?>" width="100%" alt="">
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </article>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
</div>