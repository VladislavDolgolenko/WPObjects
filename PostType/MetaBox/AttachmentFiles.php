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

namespace WPObjects\PostType\MetaBox;

class AttachmentFiles extends AbstractMetaBox
{
    public function __construct()
    {
        $this->setId('attachment-files');
        $this->setTitle('Attachment files');
        $this->setPosition('normal');
        $this->setPriority('default');
        
        $template_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'templates';
        $this->setTemplatePath($template_dir . DIRECTORY_SEPARATOR . 'attachment-files.php');
    }
    
    public function enqueues()
    {
        parent::enqueues();
        $this->getAssetsManager()
             ->enqueueScript('view-attachment-files-list');
    }
}