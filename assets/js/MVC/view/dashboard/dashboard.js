/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */


(function(MSP, Backbone){
    
    MSP.ViewDashboard = Backbone.View.extend({
        
        el: '.msp-dashboard',
        
        initialize: function () {
            var Collection = new MSP.CollectionDataType();
            Collection.fetch({reset: true});
            
            this.MainNav = new MSP.ViewDashboardMainNav({Collection: Collection});
            this.listenTo(this.MainNav, 'selected-data-type', this.renderDataTypeDashboard);
            
            this.render();
        },
        
        render: function () {
            this.$('.main-nav').html(this.MainNav.el);
        },
        
        renderDataTypeDashboard: function (DataType) {
            var List = new MSP.ViewDashboardList({model: DataType});
            this.$('.table-list').html(List.el);
            
            var Filters = new MSP.ViewDashboardFilters({model: DataType});
            this.$('.table-list-filters').html(Filters.el);
        }
        
    });
    
})(MSP, Backbone)