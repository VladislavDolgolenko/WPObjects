<?php

/**
 * @author Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @copyright Copyright (c) torbara studio (http://codecanyon.net/user/torbara/?ref=torbara)
 * @license http://codecanyon.net/licenses/standard?ref=torbara
 */

namespace WPObjects\Page;

use WPObjects\View\View;

abstract class AdminPage extends View implements 
    \WPObjects\EventManager\ListenerInterface
{
    private static $_instances = array();
    
    protected $perent_menu_id = null;
    protected $menu_name = null;
    protected $title = null;
    protected $permission = null;
    protected $id = null;
    protected $position = null; 
    protected $icon_url = null;
    
    /**
     * Multi singleton for any classes realizations
     * 
     * @return \WPObjects\Page\AdminPage
     */
    static public function getInstance()
    {
        $class = get_called_class();
        if (!isset(self::$_instances[$class])) {
            self::$_instances[$class] = new $class();
        }
        
        return self::$_instances[$class];
    }

    public function attach()
    {
        \add_action('admin_menu', array($this, 'init'));
    }
    
    public function detach()
    {
        \remove_action('admin_menu', array($this, 'init'));
    }
    
    public function init()
    {
        if (is_null($this->getParentPageId())) {
        
            \add_menu_page(
                $this->getTitle(), 
                $this->getMenuName(), 
                $this->getPermission(), 
                $this->getId(), 
                array($this, 'render'),
                $this->getIconUrl(),
                $this->getMenuPosition()
            );
        
        } else {
            
            \add_submenu_page( 
                $this->getParentPageId(),
                $this->getTitle(), 
                $this->getMenuName(), 
                $this->getPermission(), 
                $this->getId(), 
                array($this, 'render')
            );
            
        }
    }
    
    public function render()
    {
        global $_POST;
        if (isset($_POST) && count($_POST)) {
            $this->POSTAction($_POST);
        }
        
        parent::render();
    }
    
    public function getUrl($get_params = null)
    {
        //if (is_null($this->perent_menu_id)) {
            $base = admin_url( 'admin.php?page=' . $this->id );
        //} else {
        //    $base = admin_url( add_query_arg( 'page', $this->id, $this->perent_menu_id ) );
        //}
        
        if (is_null($get_params)) {
            return $base;
        }
        
        return $base . $get_params;
    }
    
    public function POSTAction($data)
    {
        return;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($string)
    {
        $this->id = $string;
        
        return $this;
    }
    
    public function getPageId()
    {
        if ($this->perent_menu_id) {
            return $this->perent_menu_id . '_page_' . $this->id;
        }
        
        return $this->id;
    }
    
    public function getParentPageId()
    {
        return $this->perent_menu_id;
    }
    
    public function setParentPageId($string)
    {
        $this->perent_menu_id = $string;
        
        return $this;
    }
    
    public function setIconUrl($string)
    {
        $this->icon_url = $string;
        
        return $this;
    }
    
    public function getIconUrl()
    {
        return $this->icon_url;
    }
    
    public function setMenuPosition($number)
    {
        $this->position = $number;
        
        return $this;
    }
    
    public function getMenuPosition()
    {
        return $this->position;
    }
    
    public function setTitle($string)
    {
        $this->title = $string;
        
        return $this;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setMenuName($string)
    {
        $this->menu_name = $string;
        
        return $this;
    }
    
    public function getMenuName()
    {
        return $this->menu_name;
    }
    
    public function setPermission($string)
    {
        $this->permission = $string;
        
        return $this;
    }
    
    public function getPermission()
    {
        return $this->permission;
    }
}
