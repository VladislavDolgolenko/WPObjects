/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
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
