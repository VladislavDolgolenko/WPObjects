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

/* @var $this \WPObjects\View\View */

/* @var $Copyright \ArrayObject */
$Copyright = $this->getServiceManager()->get('wpobjects_copyright');

?>

Created by
<a href="<?php echo esc_url($Copyright['author_link']); ?>"><?php echo esc_html($Copyright['author']); ?></a>, 
build on
<a href="<?php echo esc_url($Copyright['wpobjects_link']); ?>">\WPObjects</a>
v<?php echo esc_html($Copyright['build']); ?>