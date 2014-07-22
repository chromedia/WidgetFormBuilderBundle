
var WidgetFormBuilder = function(options){
    if (!options.form) {
        throw "WidgetFormBuilder requires the 'form' element option";
    }
    
    this.form = options.form;
    
    this.formElements = {
        widget_id: this.form.find($('#chromedia_widget_builder_form_type_widget_id')),
        widget_choices: this.form.find($('#chromedia_widget_builder_form_type_widget_choices')),
        widget_attribute: this.form.find($('#chromedia_widget_builder_form_type_widget_attribute'))
    };
};

WidgetFormBuilder.prototype.initForm = function(){
    
    // build widget choices
    var choicePrototype = this.formElements.widget_choices.data('prototype');
    
    this.formElements.widget_choices.append(choicePrototype);
};

