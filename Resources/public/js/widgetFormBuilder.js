
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
    this.bindEvents();

    WidgetUtil.displayWidgetChoices(this.formElements.widget_id, this.formElements.widget_choices);

    WidgetUtil.addRowInCollection(this.formElements.widget_choices);
    WidgetUtil.addRowInCollection(this.formElements.widget_attribute);
};


WidgetFormBuilder.prototype.bindEvents = function(){
    var self = this;

    this.form.on('click', '.add-widget-choice-trigger', function(e) {
        e.preventDefault();

        WidgetUtil.addRowInCollection(self.formElements.widget_choices);
    });

    this.form.on('click', '.add-widget-attribute-trigger', function(e) {
        e.preventDefault();

        WidgetUtil.addRowInCollection(self.formElements.widget_attribute);
    });

    this.form.on('click', '.remove-widget-choice-trigger, .remove-widget-attribute-trigger', function(e) {
        e.preventDefault();
        $(this).closest('.form-group').hide().html('');
    });

    this.formElements.widget_id.off('change').on('change', function(e) {
        e.preventDefault();

        WidgetUtil.displayWidgetChoices($(this), self.formElements.widget_choices);
    });
}


// 
var WidgetUtil = (function($) {
    return {
        choiceWidgets : ['radio', 'choice', 'checkbox'],

        addRowInCollection : function(collectionHolder) {
            var prototype = collectionHolder.data('prototype');
            var index = collectionHolder.find('.form-group').length;
            var newForm = prototype.replace(/__name__/g, index);

            collectionHolder.data('index', index + 1);
            collectionHolder.append($(newForm));
        }, 

        displayWidgetChoices : function(widget, widget_choices) {
            if (this.isChoiceWidget(widget.val())) {
                widget_choices.closest('.form-group').show();
            } else {
                widget_choices.closest('.form-group').hide();
            }
        },

        isChoiceWidget : function(widget) {
            return $.inArray(widget, this.choiceWidgets) != -1;
        }
    }
})(jQuery);
                                                                                                                                                                                                                       






