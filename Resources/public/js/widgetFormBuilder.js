
var WidgetFormBuilder = function(options){
    if (!options.form) {
        throw "WidgetFormBuilder requires the 'form' element option";
    }
    
    this.form = options.form;
    
    this.formElements = {
        widget_id: this.form.find($('#widget_id')),
        widget_choices: this.form.find($('#widget_choices')),
        widget_attribute: this.form.find($('#widget_attribute'))
    };
};

WidgetFormBuilder.prototype.initForm = function(){
    
    
};

