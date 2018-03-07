/**
 * @encoding     UTF-8
 * @package      WPObjects
 * @link         https://github.com/VladislavDolgolenko/WPObjects
 * @copyright    Copyright (C) 2018 Vladislav Dolgolenko
 * @license      MIT License
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      <help@vladislavdolgolenko.com>
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
