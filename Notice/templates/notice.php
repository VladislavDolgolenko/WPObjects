<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

/* @var $this \WPObjects\Notice\Notice */

?>

<div id="<?php echo esc_attr($this->getId()); ?>" class="<?php echo esc_attr($this->getClass()); ?>">
    <p><?php echo esc_html($this->getText()); ?></p>
</div>