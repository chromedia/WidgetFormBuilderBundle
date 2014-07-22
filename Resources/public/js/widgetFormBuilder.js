
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
    // build widget choices
    var self = this;
    var choicePrototype = this.formElements.widget_choices.data('prototype');
    this.formElements.widget_choices.append(choicePrototype);


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

    $('.add-widget-choice-trigger').on('click', function(e) {
        e.preventDefault();

        var collectionHolder = self.formElements.widget_choices;
        collectionHolder.data('index', collectionHolder.find('.form-group').length);

        addFormRowInCollection(collectionHolder);
    });
};








