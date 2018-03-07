/**
 * @encoding     UTF-8
 * @package      WPObjects
 * @link         https://github.com/VladislavDolgolenko/WPObjects
 * @copyright    Copyright (C) 2018 Vladislav Dolgolenko
 * @license      MIT License
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      <help@vladislavdolgolenko.com>
 */


(function(MSP, Backbone){
    
    MSP.CollectionDataType = Backbone.Collection.extend({
        
        url: MSP.rest_url + '/data_type',
        model: MSP.ModelDataType
        
    });
    
})(MSP, Backbone)