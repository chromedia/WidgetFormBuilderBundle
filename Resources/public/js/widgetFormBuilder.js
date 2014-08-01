
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
            widget_constraints: this.form.find($('#chromedia_widget_builder_form_type_widget_constraints'))
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
    WidgetUtil.initWidgetAttribute(this.formElements.widget_attribute);

    WidgetUtil.initWidgetConstraints(this.formElements.widget_constraints, this.constraintOptions);
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

    // Adds new constraint
    this.form.on('click', '.add-widget-constraint-trigger', function(e) {
        e.preventDefault();

        WidgetUtil.addRowInCollection(self.formElements.widget_constraints);
        
        var constraintType = self.formElements.widget_constraints.find('select:last').val();
        var optionsHolder = self.formElements.widget_constraints.find('div[data-prototype]:last');

        WidgetUtil.populateConstraintOptions(optionsHolder, WidgetUtil.constraintProperties[constraintType]);
    });

    // Handles removal of collection row
    this.form.on('click', '.remove-widget-choice-trigger, .remove-widget-attribute-trigger, .remove-widget-constraint-trigger', function(e) {
        e.preventDefault();

        if ($(this).closest('.form-group').siblings('.form-group:visible').length == 0) {
            alert('At least one value is required.');
        } else {
            $(this).closest('.form-group').hide().html('');
        }
    });

    // Handles changing of widget type
    this.formElements.widget_id.off('change').on('change', function(e) {
        e.preventDefault();

        WidgetUtil.displayWidgetChoices($(this), self.formElements.widget_choices);
    });

    // Handles changing of constraint type
    this.formElements.widget_constraints.off('change').on('change', 'select', function(e) {
        e.preventDefault();

        var constraintType = $(this).val();

        if (constraintType in WidgetUtil.constraintProperties) {
            var constraintOptionsHolder = $(this).closest('.widget-constraint').find('div[data-prototype]');
            
            WidgetUtil.populateConstraintOptions(constraintOptionsHolder, WidgetUtil.constraintProperties[constraintType]);
        }

    });
}

// 


// Provides utility methods for widgets 
var WidgetUtil = (function($) {
    return {
        choiceWidgets : ['radio', 'choice', 'checkbox'],

        constraintProperties : {},

        addRowInCollection : function(collectionHolder, prototypeName) {
            if (typeof prototypeName === "undefined" || !prototypeName) {
                prototypeName = '__name__';
            }
           
            var prototype = collectionHolder.data('prototype');
            var index = collectionHolder.children('.form-group').length;
            var newForm = $(WidgetUtil.replacePrototypeName(prototype, prototypeName, index));
          
            collectionHolder.data('index', index + 1);
            collectionHolder.append(newForm);
        },

        populateConstraintOptions : function(constraintOptionsHolder, availableOptions) {
            constraintOptionsHolder.find('.form-group').remove();

            $.each(availableOptions, function(index, value) {
                var constraintOptionPrototype = constraintOptionsHolder.data('prototype');
                var field = $(WidgetUtil.replacePrototypeName(constraintOptionPrototype, '__constraint_option_name__', value))
                
                field.find('label').html(value);

                constraintOptionsHolder.append(field);
            });
        },

        replacePrototypeName : function(prototype, prototypeName, value) {
            var regEx = new RegExp(prototypeName, 'g');
            prototype = prototype.replace(regEx, value);

            return prototype;
        },

        displayWidgetChoices : function(widget, widgetChoices) {
            if (this.isChoiceWidget(widget.val())) {
                if (widgetChoices.find('.form-group').length == 0) {
                    WidgetUtil.addRowInCollection(widgetChoices);
                }

                widgetChoices.closest('.form-group').show();
            } else {
                widgetChoices.find('.form-group').remove();
                widgetChoices.closest('.form-group').hide();
            }
        },

        initWidgetAttribute : function(widgetAttribute) {
            if (widgetAttribute.find('.form-group').length == 0) {
               WidgetUtil.addRowInCollection(widgetAttribute); 
            }
        },

        initWidgetConstraints : function(widgetConstraints, constraintProperties) {
            if (widgetConstraints.find('.form-group').length == 0) {
                WidgetUtil.addRowInCollection(widgetConstraints);
                WidgetUtil.constraintProperties = $.parseJSON(widgetConstraints.find('select').attr('data-constraint-options'));

                var constraintType = widgetConstraints.find('select').val();
                var optionsHolder = widgetConstraints.find('div[data-prototype]');

                WidgetUtil.populateConstraintOptions(optionsHolder, WidgetUtil.constraintProperties[constraintType]);
            } else {
               WidgetUtil.constraintProperties = $.parseJSON(widgetConstraints.find('select').attr('data-constraint-options')); 
           } 
        },

        isChoiceWidget : function(widget) {
            return $.inArray(widget, this.choiceWidgets) != -1;
        },
    }
})(jQuery);
                                                                                                                                                                                                                       






