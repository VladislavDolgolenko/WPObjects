/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */


(function(MSP, Backbone, _, $){
    
    MSP.ViewDashboardField = Backbone.View.extend({
        
        tagName: 'div',
        className: 'form-group',
        template: _.template(MSP.TmplDashboardField),
        
        initialize: function (options) {
            this.Field = options.Field;
            this.Collection = null;
            
            if (this.Field.type === 'qualifier') {
                this.DataType = new MSP.ModelDataType({id: this.Field.data_type_id});
                this.DataType.fetch();
                this.listenTo(this.DataType, 'sync', this.initCollection);
            } else {
                this.render();
            }
        },
        
        initCollection: function () {
            this.Collection = this.DataType.getCollection();
            this.Collection.fetch({reset: true});
            this.listenTo(this.Collection, 'reset', this.render);
        },
        
        render: function () {
            this.$el.html( this.template({Model: this.model, Field: this.Field, Collection: this.Collection}) );
            
            if (this.Field['hide'] !== undefined && this.Field['hide'] === true) {
                this.$el.hide();
            }
        }
        
    });
    
})(MSP, Backbone, _, jQuery);