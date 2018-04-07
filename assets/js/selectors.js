/**
 * @encoding     UTF-8
 * @package      WPObjects
 * @link         https://github.com/VladislavDolgolenko/WPObjects
 * @copyright    Copyright (C) 2018 Vladislav Dolgolenko
 * @license      MIT License
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      <help@vladislavdolgolenko.com>
 */

if (MSP === undefined) {
    var MSP = {};
}

(function($, MSP){
    
    MSP.initMetaBoxSelector = function () {
        var config_object = {
            plugins: ['remove_button', 'drag_drop'],
            delimiter: ',',
            persist: false,
            render: { }
        };
        
        config_object.options = [];
        $(this).find('option').each(function(){
            config_object.options.push({
                'value' : $(this).attr('value'),
                'text' : $(this).html(),
                'img' : $(this).attr('data-img'),
                'font-awesome': $(this).attr('data-font-awesome')
            });
        });
        
        if ($(this).hasClass('with-images')) {
            config_object.render.item = function (data, escape) {
                var $item = $('<div>');
                var $div = $('<div>').attr('data-value', data.value).addClass('item');
                var $img = $('<img>').attr('src', data.img).addClass('src', '');
                var $font = $('<i>').addClass('fa').addClass(data['font-awesome']);

                if (data.img) {
                    $div.append($img);
                }
                if (data['font-awesome']) {
                    $div.append($font);
                }
                
                $div.append(escape(data.text));
                
                $item.append($div);

                return $item.html();
            };
        }
        
        
        var $selector = $(this).selectize(config_object);
        $selector.on('change', function(){
            if ($(this).val() === null) {
                $selector.append('<option value="" selected>N/A</option>');
            }
        });
        
        var counter = function(){
            if ($selector.attr('multiple') === undefined) {
                return;
            }
            
            var $wrapper = $selector.parents('.selectize-wrapper');
            if (!$wrapper) {
                return;
            }
            
            var $counter = $wrapper.find('.selectize-multi-counter');
            if (!$counter) {
                return;
            }
            
            var value = $selector.val() ? $selector.val().length : 0;
            $counter.html(value);
        };
        
        $selector.on('change', counter);
        counter();
    };
    
    $('.matabox-selectors').each(function(){
        MSP.initMetaBoxSelector.call(this);
    });
    
})(jQuery, MSP, _);