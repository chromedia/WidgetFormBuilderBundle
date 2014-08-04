var CWFB_HtmlWidget = function(metadata){
    
    // //sample
    // metadata = $.parseJSON('{"widget_id":"text","widget_choices":[],"widget_attribute":[],"widget_constraints":[]}');
    // //sample

    this.widgetId = metadata.widget_id;
    this.widgetChoices = metadata.widget_choices;
    this.widgetAttributes = metadata.widget_attribute;
    this.widgetConstraints = metadata.widget_constraints;
    
    this.el = null;
};

CWFB_HtmlWidget.prototype.build = function(){
    
    this._buildElement();
    
    this
        ._buildChoices()
        ._buildAttributes();
};

CWFB_HtmlWidget.prototype._buildElement = function() {
    this.el = document.createElement('select');
};

CWFB_HtmlWidget.prototype._buildChoices = function() {
    return this;
};

CWFB_HtmlWidget.prototype._buildAttributes = function() {
    var elDom = this.el;
    this.widgetAttributes.forEach(function(item, key){
        elDom.setAttribute(item.key, item.value);
    });
    
    return this;
};


//--- Choice widget
var CWFB_ChoiceWidget = function(a, b) {
    CWFB_HtmlWidget.call(this, a);
};

CWFB_ChoiceWidget.prototype = Object.create(CWFB_HtmlWidget.prototype);

CWFB_ChoiceWidget.prototype._buildElement = function() {
    this.el = document.createElement('select');
};

CWFB_ChoiceWidget.prototype._buildChoices = function() {
    
    var elDom = this.el;
    
    this.widgetChoices.forEach(function(item) {
        var opt = document.createElement('option');
        opt.appendChild(document.createTextNode(item));
        
        elDom.appendChild(opt);
    });
    
    return this;
};
//--- End choice widget


//--- Checkbox widget
var CWFB_CheckboxWidget = function(a, b) {
    CWFB_HtmlWidget.call(this, a);
};

CWFB_CheckboxWidget.prototype = Object.create(CWFB_HtmlWidget.prototype);

CWFB_CheckboxWidget.prototype._buildElement = function() {
    this.el = document.createElement('span');
};

CWFB_CheckboxWidget.prototype._buildChoices = function() {
    
    var elDom = this.el;

    this.widgetChoices.forEach(function(choice) {
        var choice = document.createTextNode(choice);
        var checkbox = document.createElement('input');

        checkbox.type = 'checkbox';
        checkbox.name = 'cwfb_checkbox';
        checkbox.value = choice;
        checkbox.appendChild(' '+choice);

        elDom.appendChild(checkbox);
    });

    return this;
};
//--- End checkbox widget


//--- Radio button widget
var CWFB_RadioButtonWidget = function(a, b) {
    CWFB_HtmlWidget.call(this, a);
};

CWFB_RadioButtonWidget.prototype = Object.create(CWFB_HtmlWidget.prototype);

CWFB_RadioButtonWidget.prototype._buildElement = function() {
    this.el = document.createElement('span');
};

CWFB_RadioButtonWidget.prototype._buildChoices = function() {
    
    var elDom = this.el;

    this.widgetChoices.forEach(function(choice) {
        var choice = document.createTextNode(choice);
        var radioButton = document.createElement('input');

        radioButton.type = 'radio';
        radioButton.name = 'cwfb_radio';
        radioButton.value = choice;
        radioButton.appendChild(' '+choice);

        elDom.appendChild(radioButton);
    });

    return this;
};
//--- End radio button widget


//--- Text widget
var CWFB_TextWidget = function(a, b) {
    CWFB_HtmlWidget.call(this, a);
};

CWFB_TextWidget.prototype = Object.create(CWFB_HtmlWidget.prototype);

CWFB_TextWidget.prototype._buildElement = function() {
    this.el = document.createElement('input');
    this.el.type = 'text';
};
//--- End text widget


//--- Textarea widget
var CWFB_TextareaWidget = function(a, b) {
    CWFB_HtmlWidget.call(this, a);
};

CWFB_TextareaWidget.prototype = Object.create(CWFB_HtmlWidget.prototype);

CWFB_TextareaWidget.prototype._buildElement = function() {
    this.el = document.createElement('textarea');
};
//--- End textarea widget
