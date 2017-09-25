<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\PostType;

abstract class MetaBox implements \WPObjects\EventManager\ListenerInterface
{
    protected $id = null;
    protected $title = null;
    protected $position = null;
    protected $priotity = null;
    protected $PostType = null;
    
    public function __construct(PostType $PostType, $title = null)
    {
        $this->PostType = $PostType;
        $this->title = $title;
    }
    
    public function attach()
    {
        \add_action('admin_init', array($this, 'register'));
    }
    
    public function detach()
    {
        \remove_action('admin_init', array($this, 'register'));
    }
    
    public function register()
    {
        \add_meta_box( 
            $this->getId(), 
            $this->title, 
            array($this, 'render'), 
            $this->PostType->getId(), 
            $this->position, 
            $this->priotity
        );
        
        \add_action('save_post', array($this, 'preProcessing'), 10, 1);
    }
    
    abstract protected function getTemplatePath();
    
    public function preProcessing($post_id)
    {
        global $_POST;
        if (!isset($_POST['post_type'])) {
            return;
        }

        if (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || 
            $_POST['post_type'] !== $this->PostType->getId()) {
            return;
        }
        
        $this->processing($post_id, $_POST);
    }
    
    abstract protected function processing($post_id, $data);
    
    public function render($post)
    {
        $template_path = $this->getTemplatePath();
        if (!\file_exists($template_path)) {
            return;
        }
        
        $this->enqueues();
        include($template_path);
    }
    
    protected function enqueues()
    {
        
    }
    
    public function setId($int)
    {
        $this->id = $int;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setTitle($string)
    {
        $this->title = $string;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
}

