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

namespace WPObjects\AjaxController;

class ContactForm extends \WPObjects\AjaxController\Controller
{
    protected $to = null;
    protected $subject = null;
    protected $message = null;
    protected $from = null;
    
    protected $require_fields = array('message', 'from');
    
    public function getBody()
    {
        $this->readRequest();
        if (!$this->to || !$this->message || !$this->subject || !$this->from) {
            return;
        }
        
        $this->sendMail();
    }
    
    protected function readRequest()
    {
        global $_POST;
        
        foreach ($this->require_fields as $filed) {
            if (!isset($_POST[$filed]) || !$_POST[$filed]) {
                return false;
            }
        }
        
        if (!wp_verify_nonce($_POST['_wpnonce'])) {
            return false;
        }
        
        $this->from = isset($_POST['from']) ? $_POST['from'] : null;
        $this->subject = isset($_POST['subject']) ? $_POST['subject'] : null;
        $this->message = isset($_POST['message']) ? $_POST['message'] : null;
        
        return true;
    }
    
    protected function sendMail()
    {
        return \wp_mail($this->to, $this->subject, $this->message, $this->getHeaders());
    }
    
    public function setTo($email)
    {
        $this->to = $email;
        
        return $this;
    }
    
    public function getTo()
    {
        return $this->to;
    }
    
    protected function getHeaders()
    {
        return array(
            'from' => $this->from,
            'reply-to' => $this->to
        );
    }
    
}
