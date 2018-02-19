/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

(function(Backbone, _, $, MSP) {

    var ViewElement = Backbone.View.extend({

        className: 'ui-state-default attr',
        
        events: {
            'click .delete-feature' : 'remove'
        },
        
        render: function (template) {
            this.template = _.template( template );
            this.$el.html( this.template() );
            
            this.$('.matabox-selectors').each(function(){
                MSP.initMetaBoxSelector.call(this);
            });
            
            return this;
        },
    });

    var View = Backbone.View.extend({

        initialize: function () {
            var self = this;
            this.render();
        },

        events: {
            'click button.create-element': 'createAttr'
        },

        render: function () {
            var $sortable = this.$( ".elements" );
            $sortable.sortable();
            $sortable.disableSelection();
            
            this.$('.attr').each(function(){
                new ViewElement({el: $(this)});
            });
            
            return this;
        },

        createAttr: function () {
            var template = this.$('.souce-attr').html();
            var ViewAttr = new ViewElement();
            this.$('.elements').append(ViewAttr.render(template).el);
            return false;
        }

    });

    $('.custom-attrs').each(function(index, element){
        new View({el: $(element)});
    });

})(Backbone, _, jQuery, MSP);
