/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

(function($){
    
    $.fn.boxCallapse = function () {
        
        $(this).each(function(){
            var $box = $(this);
            var $trigger = $box.find('.collapse-trigger').first();

            $trigger.on('click', function () {
                $box.toggleClass('colapse-show');
            });
        });
        
    };
    
})(jQuery);