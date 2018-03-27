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

/* @var $this \WPObjects\PostType\MetaBox\AttachmentFiles */

$files_ids = $this->getPostModel()->getMeta('_attachment_files_ids');
if (!$files_ids) {
    $files_ids = array();
} else if (!is_array($files_ids)) {
    $files_ids = array($files_ids);
}

$files_ids_string = implode(',', $files_ids ? $files_ids : array());

?>

<div class="js-attachment-files"
     data-attachments-ids="<?php echo esc_attr($files_ids_string); ?>"
></div>