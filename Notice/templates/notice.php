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

/* @var $this \WPObjects\Notice\Notice */

?>

<div id="<?php echo esc_attr($this->getId()); ?>" class="<?php echo esc_attr($this->getClass()); ?>">
    <p><?php echo esc_html($this->getText()); ?></p>
</div>