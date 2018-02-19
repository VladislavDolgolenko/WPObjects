/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */


(function(MSP, Backbone){
    
    MSP.CollectionDataType = Backbone.Collection.extend({
        
        url: MSP.rest_url + '/data_type',
        model: MSP.ModelDataType
        
    });
    
})(MSP, Backbone)