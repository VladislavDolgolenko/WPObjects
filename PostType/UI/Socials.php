<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace MSP\MetaBox;

class Socials extends AbstractMetaBox
{
    public function __construct()
    {
        $this->setId('socials');
        $this->setTitle('Socials links');
        $this->setPosition('normal');
        $this->setPriority('default');
    }
    
    public function processing(\MSP\WPObjects\Model\AbstractPostModel $Post, $data)
    {
        if (!isset($data['social_counter']) || !is_array($data['social_counter'])) {
            return array();
        }
        
        $social_counter = $data['social_counter'];
        $_socials = array();
        foreach ($social_counter as $key => $count) {
            $social = array( 
                'icon_class' => sanitize_text_field($data['social_icon_class'][$key]), 
                'link' => sanitize_text_field($data['social_link'][$key]), 
            );

            if ($social['icon_class'] && $social['link']) {
                $_socials[] = $social;
            }
        }

        return array(
            '_socials' => $_socials
        );
    }
    
    public function getSocialsSelector($selected = null)
    {
        $icons_pull = array("fa-500px" , "fa-adn" , "fa-amazon" , "fa-android" , "fa-angellist" , "fa-apple" , "fa-bandcamp" , "fa-behance" , "fa-behance-square" , "fa-bitbucket" , "fa-bitbucket-square" , "fa-bitcoin" , "fa-black-tie" , "fa-bluetooth" , "fa-bluetooth-b" , "fa-btc" , "fa-buysellads" , "fa-cc-amex" , "fa-cc-diners-club" , "fa-cc-discover" , "fa-cc-jcb" , "fa-cc-mastercard" , "fa-cc-paypal" , "fa-cc-stripe" , "fa-cc-visa" , "fa-chrome" , "fa-codepen" , "fa-codiepie" , "fa-connectdevelop" , "fa-contao" , "fa-css3" , "fa-dashcube" , "fa-delicious" , "fa-deviantart" , "fa-digg" , "fa-dribbble" , "fa-dropbox" , "fa-drupal" , "fa-edge" , "fa-eercast" , "fa-empire" , "fa-envira" , "fa-etsy" , "fa-expeditedssl" , "fa-fa" , "fa-facebook" , "fa-facebook-f" , "fa-facebook-official" , "fa-facebook-square" , "fa-firefox" , "fa-first-order" , "fa-flickr" , "fa-font-awesome" , "fa-fonticons" , "fa-fort-awesome" , "fa-forumbee" , "fa-foursquare" , "fa-free-code-camp" , "fa-ge" , "fa-get-pocket" , "fa-gg" , "fa-gg-circle" , "fa-git" , "fa-git-square" , "fa-github" , "fa-github-alt" , "fa-github-square" , "fa-gitlab" , "fa-gittip" , "fa-glide" , "fa-glide-g" , "fa-google" , "fa-google-plus" , "fa-google-plus-circle" , "fa-google-plus-official" , "fa-google-plus-square" , "fa-google-wallet" , "fa-gratipay" , "fa-grav" , "fa-hacker-news" , "fa-houzz" , "fa-html5" , "fa-imdb" , "fa-instagram" , "fa-internet-explorer" , "fa-ioxhost" , "fa-joomla" , "fa-jsfiddle" , "fa-lastfm" , "fa-lastfm-square" , "fa-leanpub" , "fa-linkedin" , "fa-linkedin-square" , "fa-linode" , "fa-linux" , "fa-maxcdn" , "fa-meanpath" , "fa-medium" , "fa-meetup" , "fa-mixcloud" , "fa-modx" , "fa-odnoklassniki" , "fa-odnoklassniki-square" , "fa-opencart" , "fa-openid" , "fa-opera" , "fa-optin-monster" , "fa-pagelines" , "fa-paypal" , "fa-pied-piper" , "fa-pied-piper-alt" , "fa-pied-piper-pp" , "fa-pinterest" , "fa-pinterest-p" , "fa-pinterest-square" , "fa-product-hunt" , "fa-qq" , "fa-quora" , "fa-ra" , "fa-ravelry" , "fa-rebel" , "fa-reddit" , "fa-reddit-alien" , "fa-reddit-square" , "fa-renren" , "fa-resistance" , "fa-safari" , "fa-scribd" , "fa-sellsy" , "fa-share-alt" , "fa-share-alt-square" , "fa-shirtsinbulk" , "fa-simplybuilt" , "fa-skyatlas" , "fa-skype" , "fa-slack" , "fa-slideshare" , "fa-snapchat" , "fa-snapchat-ghost" , "fa-snapchat-square" , "fa-soundcloud" , "fa-spotify" , "fa-stack-exchange" , "fa-stack-overflow" , "fa-steam" , "fa-steam-square" , "fa-stumbleupon" , "fa-stumbleupon-circle" , "fa-superpowers" , "fa-telegram" , "fa-tencent-weibo" , "fa-themeisle" , "fa-trello" , "fa-tripadvisor" , "fa-tumblr" , "fa-tumblr-square" , "fa-twitch" , "fa-twitter" , "fa-twitter-square" , "fa-usb" , "fa-viacoin" , "fa-viadeo" , "fa-viadeo-square" , "fa-vimeo" , "fa-vimeo-square" , "fa-vine" , "fa-vk" , "fa-wechat" , "fa-weibo" , "fa-weixin" , "fa-whatsapp" , "fa-wikipedia-w" , "fa-windows" , "fa-wordpress" , "fa-wpbeginner" , "fa-wpexplorer" , "fa-wpforms" , "fa-xing" , "fa-xing-square" , "fa-y-combinator" , "fa-y-combinator-square" , "fa-yahoo" , "fa-yc" , "fa-yc-square" , "fa-yelp" , "fa-yoast" , "fa-youtube" , "fa-youtube-play" , "fa-youtube-square" , "fa-warning");
        
        $options = array();
        foreach ($icons_pull as $icon) {
            $icon_names = explode('-', $icon);
            if (!isset($icon_names[1])) {
                continue;
            }
            
            $social_name = ucfirst($icon_names[1]);
            if (isset($icon_names[2])) {
                $social_name .= ' ' . $icon_names[2];
            }
            
            $options[] = array(
                'id' => "fa " . $icon,
                'name' => $social_name,
                'font-awesome' => $icon
            );
        }
        
        $name = 'social_icon_class';
        $vertical = true;
        $desctiption = '';
        $multibple = false;
        $array_result = true;
        $lable = null;
        
        include $this->getPartTemplatePath('selector');
    }
    
    public function enqueues()
    {
        parent::enqueues();
        
        wp_enqueue_script('msp_metabox_attributes', MSP_PATH_URL . 'js/meta-boxes/attributes.js', array('backbone'), null, true);
    }
    
    public function getElements()
    {
        $elements = $this->getPostModel()->getMeta('_socials');
    
        if (!is_array($elements) || count($elements) === 0) {
            $elements = array(
                array(
                    'icon_class' => '',
                    'link' => ''
                )
            );
        }
        
        if (!is_array(current($elements))) {
            $elements = array($elements);
        }
        
        return $elements;
    }
}