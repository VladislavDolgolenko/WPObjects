/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
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