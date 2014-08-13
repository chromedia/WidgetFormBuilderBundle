
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
            widget_attribute: this.form.find($('#chromedia_widget_builder_form_type_widget_attribute')),
            widget_constraints: this.form.find($('#chromedia_widget_builder_form_type_widget_constraints')),
            widget_date_widgets: this.form.find($('#chromedia_widget_builder_form_type_widget_date_widgets')),
        };
    }
    else {
        // TODO: validate
        this.formElements = options.formElements;
    }
};


WidgetFormBuilder.prototype.initForm = function(){
    var self = this;

    this.formElements.widget_id.off('change').on('change', function(e) {
        e.preventDefault();

        if (WidgetUtil.isChoiceWidget($(this).val())) {
            self.formElements.widget_choices.displayChoices();
        } else {
            self.formElements.widget_choices.removeChoices();
        }
    });

    this.populateWidgetChoices();
    this.populateWidgetAttributes();
    this.populateWidgetConstraints();

};

// widget choices
WidgetFormBuilder.prototype.populateWidgetChoices = function(){
    var self = this;
    var widgetChoice = this.formElements.widget_choices;

    // add events
    var addEvents = function() {
        self.form.on('click', '.add-widget-choice-trigger', function(e) {
            e.preventDefault();

            widgetChoice.addCollectionRow();
        });

        self.form.on('click', '.remove-widget-choice-trigger', function(e) {
            e.preventDefault();

            $(this).removeCollectionRow({ isRequired : true });
        });
    };

    // initialize widget choices
    var initWidgetChoices = function() {
        if (WidgetUtil.isChoiceWidget(self.formElements.widget_id.val())) {
            widgetChoice.displayChoices();
        } else {
            widgetChoice.find('.form-group').remove();
            widgetChoice.closest('.form-group').hide();
        }

        addEvents();
    }

    initWidgetChoices();
}

// Widget atribute
WidgetFormBuilder.prototype.populateWidgetAttributes = function(){
    var widgetAttribute = this.formElements.widget_attribute;
    var self = this;

    // add events
    var addEvents = function() {
        self.form.on('click', '.add-widget-attribute-trigger', function(e) {
            e.preventDefault();

            widgetAttribute.addCollectionRow();
        });

        self.form.on('click', '.remove-widget-attribute-trigger', function(e) {
            e.preventDefault();

            $(this).removeCollectionRow({ isRequired : false });
        });
    }

    // do displaying
    var initWidgetAttributes = function() {
        if (widgetAttribute.find('.form-group').length == 0) {
            widgetAttribute.addCollectionRow();
        }

        addEvents();
    }

    initWidgetAttributes();
}

// Widget constraints
WidgetFormBuilder.prototype.populateWidgetConstraints = function(){
    var self = this;
    var widgetConstraints = this.formElements.widget_constraints;
    var constraintOptions = {};

    var initWidgetConstraints = function(form, formElements) {
        if (widgetConstraints && !widgetConstraints.is(':visible')) {
            widgetConstraints.closest('.form-group').remove();
        } else {
            if (widgetConstraints.find('.form-group').length == 0) {
                widgetConstraints.addCollectionRow();

                var constraintType = widgetConstraints.find('select').val();
                var optionsHolder = widgetConstraints.find('div[data-prototype]');
                var options = widgetConstraints.find('select').attr('data-constraint-options');

                constraintOptions = $.parseJSON(options);

                populateConstraintOptions(optionsHolder, constraintOptions[constraintType]);
            } else {
                var options = widgetConstraints.find('select').attr('data-constraint-options');

                constraintOptions = $.parseJSON(options); 
            } 

            addEvents();
        }
    };

    var populateConstraintOptions = function(constraintOptionsHolder, availableOptions) {
        constraintOptionsHolder.find('.form-group').remove();

        $.each(availableOptions, function(index, value) {
            var constraintOptionPrototype = constraintOptionsHolder.data('prototype');
            var field = $(WidgetUtil.replacePrototypeName(constraintOptionPrototype, '__constraint_option_name__', value))
            
            field.find('label').html(value);

            constraintOptionsHolder.append(field);
        });
    };

    var addEvents = function() {
        self.form.on('click', '.add-widget-constraint-trigger', function(e) {
            e.preventDefault();

            widgetConstraints.addCollectionRow();
            
            var constraintType = widgetConstraints.find('select:last').val();
            var optionsHolder = widgetConstraints.find('div[data-prototype]:last');
            var options = constraintOptions[constraintType];

            populateConstraintOptions(optionsHolder, options);
        });

        self.form.on('click', '.remove-widget-constraint-trigger', function(e) {
            e.preventDefault();

            $(this).removeCollectionRow({ isRequired : false });
        });

        // Handles changing of constraint type
        widgetConstraints.off('change').on('change', 'select', function(e) {
            e.preventDefault();

            var constraintType = $(this).val();

            if (constraintType in constraintOptions) {
                var constraintOptionsHolder = $(this).closest('.widget-constraint').find('div[data-prototype]');
                var options = constraintOptions[constraintType];

                populateConstraintOptions(constraintOptionsHolder, options);
            }
        });
    };

    initWidgetConstraints();
}


// Reusable by different widget 
$.fn.addCollectionRow = function(options) {
    var props = $.extend({
        'prototypeName' : '__name__'
    }, options);

    var prototype = $(this).data('prototype');
    var index = $(this).children('.form-group').length;
    var newForm = $(WidgetUtil.replacePrototypeName(prototype, props.prototypeName, index));
  
    this.data('index', index + 1);
    this.append(newForm);

    return this;
},

$.fn.removeCollectionRow = function(options) {
    var props = $.extend({
        'onRemoveDone' : function() {},
        'isRequired' : true
    }, options);

    if (props.isRequired && $(this).closest('.form-group').siblings('.form-group:visible').length == 0) {
        alert('At least one value is required.');
    } else {
        if ($(this).closest('.form-group').siblings('.form-group:visible').length == 0) {
            // temporary only. Just add button for us to add values.
            //$(this).closest('.form-group').append('<a href="#" class="add-widget-attribute-trigger">Add</a>')
        }

        $(this).closest('.form-group').hide().html('');
    }
}

$.fn.displayChoices = function() {
    if ($(this).find('.form-group').length == 0) {
        $(this).addCollectionRow();
    }

    $(this).closest('.form-group').show();
}

$.fn.removeChoices = function() {
    $(this).empty();
    $(this).closest('.form-group').hide();
}


// Provides utility methods for widgets 
var WidgetUtil = (function($) {
    return {
        choiceWidgets : ['radio', 'choice', 'checkbox'],

        replacePrototypeName : function(prototype, prototypeName, value) {
            var regEx = new RegExp(prototypeName, 'g');
            prototype = prototype.replace(regEx, value);

            return prototype;
        },

        isChoiceWidget : function(widget) {
            return $.inArray(widget, this.choiceWidgets) != -1;
        },
    }
})(jQuery);
                                                                                                                                                                                                                       