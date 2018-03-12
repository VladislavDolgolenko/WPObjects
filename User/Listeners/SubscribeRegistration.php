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

namespace WPObjects\User\Listeners;

class SubscribeRegistration implements
    \WPObjects\EventManager\ListenerInterface
{
    public function attach()
    {
        \add_action('login_form_register', array($this, 'process'));
    }
    
    public function detach()
    {
        \remove_action('login_form_register', array($this, 'process'));
    }
    
    public function process()
    {
        global $_POST;

        if( empty($_POST['user_login']) 
            && isset($_POST['user_email']) 
            && !empty($_POST['user_email']) 
            && isset($_POST['user_subscribe'])) {

            $email = $_POST['user_email'];
            $email_elements = explode('@', $email);
            if (is_array($email_elements) && count($email_elements) > 0) { 
                $_POST['user_login'] = $email_elements[0];
            }
        }
    }
}