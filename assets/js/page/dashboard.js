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
    
    // Rewrite backbone ajax for include auth params in request Headers
    Backbone.ajax = function(options) {
        var beforeSend = options.beforeSend;
        options.beforeSend = function(xhr) {
            xhr.setRequestHeader('X-WP-Nonce', MSP.nonce);
            if (beforeSend) return beforeSend.apply(this, arguments);
        };
        
        return Backbone.$.ajax.apply(Backbone.$, [options]);
    };
    
    var Dashboard = new MSP.ViewDashboard();
    
})(MSP, Backbone);