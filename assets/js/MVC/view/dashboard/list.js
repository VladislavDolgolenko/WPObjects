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
