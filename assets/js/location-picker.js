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
    
    $('.metabox-location-picker').each(function(){
        
        var first_load = true;
        $(this).find('.placepicker').placepicker({
            placeChanged: function () {
                var location = this.getLocation();
                $('[name=_location_latitude]').val(location.latitude);
                $('[name=_location_longitude]').val(location.longitude);
                
                if (first_load) {
                    this.reload();
                }
                first_load = false;
            }
        });
        
    });
    
})(jQuery);
