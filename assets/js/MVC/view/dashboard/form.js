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
    
    MSP.ViewDashboardForm = Backbone.View.extend({
        
        template: _.template(MSP.TmplDashboardForm),
        className: 'msp-bootstrap-wrapper',
        
        initialize: function (options) {
            this.DataType = options.DataType;
            this.render();
            this.listenTo(this.model, 'sync', this.updateCollection);
            this.listenTo(this.model, "invalid", this.writeError);
        },  
        
        render: function () {
            $('body').append(this.el);
            this.$el.html(this.template({Model: this.model, DataType: this.DataType}));
            this.$('.modal').modal('show');
            this.$('.modal').on('hidden.bs.modal', _.bind(this.remove, this));
            
            this.$('.fields').html('');
            var Fields = this.DataType.get('form_fields');
            _.each(Fields, _.bind(this.renderField, this));
        },
        
        renderField: function (Field) {
            var ViewField = new MSP.ViewDashboardField({model: this.model, Field: Field});
            this.$('.fields').append(ViewField.$el);
        },
        
        events: {
            'click .form-action-success': 'success',
            'click .form-action-close': 'close'
        },
        
        readForm: function () {
            var Fields = this.DataType.get('form_fields');
            _.each(Fields, _.bind(this.readField, this));
        },
        
        readField: function (Field) {
            var $element = this.$('[name='+ Field.id +']').first();
            if (Field.type !== 'checkbox') {
                var value = $element.val();
            } else {
                var value = $element.is(":checked") ? true : false;
            }
            
            if (!value && Field.require === true) {
                $element.parents('.form-group').first().addClass('has-warning');
                return;
            } else {
                $element.parents('.form-group').first().removeClass('has-warning');
            }
            
            if (Field.id === this.model.idAttribute && this.model.isNew()) {
                this.model.set('_creation_id', value);
            } else {
                this.model.set(Field.id, value);
            }
        },
        
        writeError: function (model, error) {
            this.$('.form-action-model-error').html(error);
        },
        
        success: function () {
            this.readForm();
            
            console.log(this.model.isValid());
            if (this.model.isValid()) {
                this.model.save(null, {success: _.bind(this.close, this)});
            }
        },
        
        updateCollection: function () {
            var Colleciton = this.DataType.getCollection();
            Colleciton.fetch({reset: true, data: Colleciton.fetchFilters});
        },

        close: function () {
            this.$('.modal').modal('hide');
        }
    });
    
})(MSP, Backbone, _, jQuery);