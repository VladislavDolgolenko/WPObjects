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
    
    MSP.ViewDashboardMainNav = Backbone.View.extend({
        
        template: _.template(MSP.TmplDashboardMainNav),
        tagName: 'ul',
        attributes: {'role' : 'tablist'},
        
        initialize: function (options) {
            this.Collection = options.Collection;
            
            this.listenTo(this.Collection, 'reset', this.render);
            this.render();
        },
        
        render: function () {
            this.$el.html( this.template({Collection: this.Collection }) );
            var DataType = this.Collection.at(0);
            if (DataType) {
                this.setDataType(DataType);
            }
        },
        
        events: {
            'click a' : 'selectDataType'
        },
        
        selectDataType: function (e) {
            var id = $(e.currentTarget).attr('data-type-id');
            var DataType = this.Collection.get(id);
            this.setDataType(DataType);
        },
        
        setDataType: function (DataType) {
            this.$('li').removeClass('active');
            $('a[data-type-id='+ DataType.id +']').parents('li').first().addClass('active');
            this.trigger('selected-data-type', DataType);
        }
        
    });
    
})(MSP, Backbone, _, jQuery)