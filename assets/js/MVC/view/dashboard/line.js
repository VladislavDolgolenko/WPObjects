/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

(function(MSP, Backbone, _, $){
    
    MSP.ViewDashboardLine = Backbone.View.extend({
        
        template: _.template(MSP.TmplDashboardLine),
        tagName: 'tr',
        
        initialize: function (options) {
            this.DataType = options.DataType;
            
            this.listenTo(this.model, 'change', this.render);
            this.listenTo(this.model, 'remove', this.remove);
            
            this.render();
        },
        
        render: function () {
            if (this.model.get('active') === false) {
                this.$el.addClass('disable');
            }  else {
                this.$el.removeClass('disable');
            }
            
            this.$el.html( this.template({Model: this.model, DataType: this.DataType }));
        },
        
        events: {
            'click .form-action-edit' : 'showEditPanel',
            'click .form-action-remove': 'removeModel',
            'click .form-action-change-status': 'changeStatus'
        },
        
        changeStatus: function () {
            var status = this.model.get('active');
            this.model.set('active', status ? false : true);
            this.model.save();
        },
        
        removeModel: function () {
            this.model.destroy({wait: true});
        },
        
        showEditPanel: function () {
            var Form = new MSP.ViewDashboardForm({model: this.model, DataType: this.DataType});
        }
        
    });
    
})(MSP, Backbone, _, jQuery);
