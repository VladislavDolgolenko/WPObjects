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