/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

(function($, Backbone, _, api){
    
    var ConstroleView = Backbone.View.extend({
    
        initialize: function (options) {
            this.PresetsParams = options.PresetsParams;
            this.render();
        },
        
        render: function () {
            var self = this;
            _.each(this.PresetsParams, function(params, preset_id){
                
                var colors = self.filterColorValues(params);
                var line_width = 100 / colors.length;
                var $button = self.$('div[data-preset-id="' + preset_id + '"] .lines-wrapper').first();
                
                _.each(colors, function(color){
                    var $line = $('<div class="color-line"></div>');
                    $line.css({'width': line_width + "%", 'background-color': color});
                    $line.appendTo($button);
                });
            });
        },
        
        filterColorValues: function (params) {
            
            var result = [];
            _.each(params, function (value){
                if (value.indexOf('#') !== -1 || value.indexOf('rgb') !== -1) {
                    result.push(value);
                }
            });
            
            return result;
        },
        
        events: {
            'click .js-select-preset': 'selectPreset'
        },
        
        selectPreset: function (e) {
            e.preventDefault();
            var preset_id = $(e.currentTarget).attr('data-preset-id');
            if (!preset_id) {
                return;
            }
            
            var params = this.getPresetParams(preset_id);
            if (!params) {
                return;
            }
            
            this.setupParams(params);
            return false;
        },
        
        setupParams: function (params) {
            _.each(params, _.bind(this.setupParam, this));
        },
        
        setupParam: function (value, setting_id) {
            api(setting_id, function(setting){
                setting.set(value);
            });
        },
        
        getPresetParams: function (preset_id) {
            if (this.PresetsParams[preset_id] === undefined) {
                return null;
            }
            
            return this.PresetsParams[preset_id];
        }
    });
    
    api.bind('ready', function () {
    
        $('.js-vc-addons-customizer-presets-constrole').each(function(){
            var $el = $(this);
            var controle_id = $el.attr('data-controle-id');
            var Controle = api.control.instance(controle_id);
            var presets_params = Controle.params['presets_params'];
            
            new ConstroleView({el: $el, PresetsParams: presets_params});
        });
    
    });
    
})(jQuery, Backbone, _, wp.customize);