
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

    // build widget choices
    var choicePrototype = this.formElements.widget_choices.data('prototype');
    this.formElements.widget_choices.append(choicePrototype);

    //build widget attributes
    var attributePrototype = this.formElements.widget_attribute.data('prototype');
    this.formElements.widget_attribute.append(attributePrototype);

    //bind events
    var addFormRowInCollection = function($_collectionHolder) {
        var prototype = $_collectionHolder.data('prototype');
        var index = $_collectionHolder.data('index');
        var newForm = prototype.replace(/__name__/g, index);

        $_collectionHolder.data('index', index + 1);
        $_collectionHolder.append($(newForm));
    }

    this.form.on('click', '.remove-widget-choice-trigger', function(e) {
        e.preventDefault();
        $(this).closest('.form-group').hide().html('');
    });

    this.formElements.widget_choices.on('click', '.add-widget-choice-trigger', function(e) {
        e.preventDefault();

        self.formElements.widget_choices.data('index', self.formElements.widget_choices.find('.form-group').length);
        addFormRowInCollection(self.formElements.widget_choices);
    });

    this.formElements.widget_attribute.on('click', '.add-widget-choice-trigger', function(e) {
        e.preventDefault();

        self.formElements.widget_attribute.data('index', self.formElements.widget_attribute.find('.form-group').length);

        addFormRowInCollection(self.formElements.widget_attribute);
    });
};








