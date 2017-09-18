<?php

/**
 * @author Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @copyright Copyright (c) torbara studio (http://codecanyon.net/user/torbara/?ref=torbara)
 * @license http://codecanyon.net/licenses/standard?ref=torbara
 */

namespace WPObjects\Page;

abstract class AdminPage implements \WPObjects\EventManager\ListenerInterface
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
    
    public function init()
    {
        if (is_null($this->perent_menu_id)) {
        
            \add_menu_page(
                $this->title, 
                $this->menu_name, 
                $this->permission, 
                $this->id, 
                array($this, 'render'),
                $this->icon_url,
                $this->position
            );
        
        } else {
            
            \add_submenu_page( 
                $this->perent_menu_id,
                $this->title, 
                $this->menu_name, 
                $this->permission, 
                $this->id, 
                array($this, 'render')
            );
            
        }
    }
    
    public function detach()
    {
        \remove_action('admin_menu', array($this, 'init'));
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
        if (is_null($this->perent_menu_id)) {
            $base = admin_url( 'admin.php?page=' . $this->id );
        } else {
            $base = admin_url( add_query_arg( 'page', $this->id, $this->perent_menu_id ) );
        }
        
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
}
