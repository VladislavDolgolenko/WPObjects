<?php

/**
 * @author Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @copyright Copyright (c) torbara studio (http://codecanyon.net/user/torbara/?ref=torbara)
 * @license http://codecanyon.net/licenses/standard?ref=torbara
 */

namespace WPObjects\Page;

abstract class AdminPage implements 
    \WPObjects\EventManager\ListenerInterface,
    \WPObjects\Service\ManagerInterface
{
    private static $_instances = array();
    
    /**
     * Global service manager
     * 
     * @var \WPobjects\Service\Manager
     */
    protected $ServiceManager = null;
    
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
        
        $template_path = $this->getTemplatePath();
        if (!\file_exists($template_path)) {
            return;
        }
        
        $this->enqueues();
        include($template_path);
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
    
    abstract protected function enqueues();
    
    abstract protected function getTemplatePath();
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($string)
    {
        $this->id = $string;
    }
    
    public function getPageId()
    {
        if ($this->perent_menu_id) {
            return $this->perent_menu_id . '_page_' . $this->id;
        }
        
        return $this->id;
    }
    
    public function setServiceManager(\WPObjects\Service\Manager $ServiceManager)
    {
        $this->ServiceManager = $ServiceManager;
        
        return $this;
    }
    
    public function getServiceManager()
    {
        if (is_null($this->ServiceManager)) {
            throw new \Exception('Undefined service manager');
        }
        
        return $this->ServiceManager;
    }
    
    public function getParentPageId()
    {
        return $this->perent_menu_id;
    }
    
    public function setParentPageId($string)
    {
        $this->perent_menu_id = $string;
    }
    
    public function setIconUrl($string)
    {
        $this->icon_url = $string;
    }
    
    public function getIconUrl()
    {
        return $this->icon_url;
    }
    
    public function setMenuPosition($number)
    {
        $this->position = $number;
    }
    
    public function getMenuPosition()
    {
        return $this->position;
    }
    
    public function setTitle($string)
    {
        $this->title = $string;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setMenuName($string)
    {
        $this->menu_name = $string;
    }
    
    public function getMenuName()
    {
        return $this->menu_name;
    }
    
    public function setPermission($string)
    {
        $this->permission = $string;
    }
    
    public function getPermission()
    {
        return $this->permission;
    }
}
