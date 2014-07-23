
var WidgetFormBuilder = function(options){
    if (!options.form) {
        throw "WidgetFormBuilder requires the 'form' element option";
    }
    
    this.form = options.form;
    

    if (!options.formElements) {
        // build defaults
        this.formElements = {
            widget_id: this.form.find($('#chromedia_widget_builder_form_type_widget_id')),
            widget_choices: this.form.find($('#chromedia_widget_builder_form_type_widget_choices')),
            widget_attribute: this.form.find($('#chromedia_widget_builder_form_type_widget_attribute'))
        };
    }
    else {
        // TODO: validate
        this.formElements = options.formElements;
    }
};

WidgetFormBuilder.prototype.initForm = function(){
    var self = this;

    // TODO: Check if widget has choices
    // build widget choices
    WidgetUtil.addRowInCollection(self.formElements.widget_choices);
    this.form.on('click', '.add-widget-choice-trigger', function(e) {
        e.preventDefault();

        WidgetUtil.addRowInCollection(self.formElements.widget_choices);
    });


    // build widget attributes
    WidgetUtil.addRowInCollection(self.formElements.widget_attribute);
    this.form.on('click', '.add-widget-attribute-trigger', function(e) {
        e.preventDefault();

        WidgetUtil.addRowInCollection(self.formElements.widget_attribute);
    });

    // bind remove event
    this.form.on('click', '.remove-widget-choice-trigger, .remove-widget-attribute-trigger', function(e) {
        e.preventDefault();
        $(this).closest('.form-group').hide().html('');
    });
};


// 
var WidgetUtil = (function($) {
    return {
        addRowInCollection : function(collectionHolder) {
            var prototype = collectionHolder.data('prototype');
            var index = collectionHolder.find('.form-group').length;
            var newForm = prototype.replace(/__name__/g, index);

            collectionHolder.data('index', index + 1);
            collectionHolder.append($(newForm));
        }
    }
})(jQuery);
                                                                                                                                                                                                                       






