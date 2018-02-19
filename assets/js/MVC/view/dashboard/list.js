/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */


(function(MSP, Backbone, _, $){
    
    MSP.ViewDashboardList = Backbone.View.extend({
        
        template: _.template(MSP.TmplDashboardList),
        tagName: 'table',
        className: 'dashboard-table',
        
        initialize: function () {
            this.Collection = this.model.getCollection();
            this.Collection.fetchFilters = {'active': null};
            this.Collection.fetch({reset: true, data: this.Collection.fetchFilters});
            this.listenTo(this.Collection, 'reset', this.render);
            this.render();
        },
        
        render: function () {
            this.$el.html( this.template({DataType: this.model}) );
            
            this.$('tbody').html('');
            
            var self = this;
            this.Collection.each(function(Model){
                var Line = new MSP.ViewDashboardLine({model: Model, DataType: self.model});
                self.$('tbody').append(Line.el);
            });
        },
        
        events: {
            'click .add-new' : 'addNew'
        },
        
        addNew: function () {
            var ModelCalss = this.model.getModelClass();
            var Form = new MSP.ViewDashboardForm({model: new ModelCalss(), DataType: this.model});
        }
        
    });
    
})(MSP, Backbone, _, jQuery);
