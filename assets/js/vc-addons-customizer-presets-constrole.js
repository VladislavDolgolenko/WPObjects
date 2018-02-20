/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

(function($, Backbone, api){
    
    api.bind('ready', function () {
    
        $('.js-vc-addons-customizer-presets-constrole').each(function(){
            var $el = $(this);
            console.log($el);
        });
    
    });
    
})(jQuery, Backbone, wp.customize);