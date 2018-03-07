/**
 * @encoding     UTF-8
 * @package      WPObjects
 * @link         https://github.com/VladislavDolgolenko/WPObjects
 * @copyright    Copyright (C) 2018 Vladislav Dolgolenko
 * @license      MIT License
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      <help@vladislavdolgolenko.com>
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