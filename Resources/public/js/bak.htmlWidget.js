var CWFB_HtmlWidget = function(metadata){
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

    return this;
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
        for (attributeName in item) {}
    
        elDom.setAttribute(attributeName, item[attributeName]);
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

//--- Expanded CHoices
var CWFB_ExpandedChoiceWidget = function(a, b, choiceType) {
    CWFB_HtmlWidget.call(this, a);

    this.choiceType = choiceType;
};

CWFB_ExpandedChoiceWidget.prototype = Object.create(CWFB_HtmlWidget.prototype);

CWFB_ExpandedChoiceWidget.prototype._buildElement = function() {
    this.el = document.createElement('div');
};

CWFB_ExpandedChoiceWidget.prototype._buildChoices = function() {
    var elDom = this.el;
    var type = this.choiceType;

    this.widgetChoices.forEach(function(item) {
        var element = document.createElement('input');

        element.type = type;
        // element.name = 'cwfb_'+type;
        element.value = item;

        var label = document.createElement('label');
        label.appendChild(document.createTextNode(item));

        elDom.appendChild(element);
        elDom.appendChild(label);
    });

    return this;
};

CWFB_ExpandedChoiceWidget.prototype._buildAttributes = function() {
    
    var elDom = this.el;

    this.widgetAttributes.forEach(function(item, key){
        var inputs = elDom.getElementsByTagName('input');

        for(var ctr = 0; ctr < inputs.length; ctr++) {
            for (attributeName in item) {}
            inputs[ctr].setAttribute(attributeName, item[attributeName]);
        }
    });
    
    return this;
};
//--- End of expanded choices


//--- Checkbox widget
var CWFB_CheckboxWidget = function(a, b) {
    CWFB_ExpandedChoiceWidget.call(this, a, b, 'checkbox');
};

CWFB_CheckboxWidget.prototype = Object.create(CWFB_ExpandedChoiceWidget.prototype);

//--- End checkbox widget


//--- Radio button widget
var CWFB_RadioButtonWidget = function(a, b) {
    CWFB_ExpandedChoiceWidget.call(this, a, b, 'radio');
};

CWFB_RadioButtonWidget.prototype = Object.create(CWFB_ExpandedChoiceWidget.prototype);
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


//--- Date widget - Given that date widget is single_text
var CWFB_DateWidget = function(a, b) {
    CWFB_HtmlWidget.call(this, a);
};

CWFB_DateWidget.prototype = Object.create(CWFB_HtmlWidget.prototype);

CWFB_DateWidget.prototype._buildElement = function() {
    this.el = document.createElement('input');
    this.el.type = 'date';
    this.el.attributes['data-provide'] = 'datepicker';
};
//--- End of date widget


//--- File widget
var CWFB_FileWidget = function(a, b) {
    CWFB_HtmlWidget.call(this, a);
};

CWFB_FileWidget.prototype = Object.create(CWFB_HtmlWidget.prototype);

CWFB_FileWidget.prototype._buildElement = function() {
    this.el = document.createElement('input');
    this.el.type = 'file';
};
//--- End of date widget

