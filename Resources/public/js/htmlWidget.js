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


var CWFB_TextWidget = function(a, b) {
    CWFB_HtmlWidget.call(this, a);
};

CWFB_TextWidget.prototype = Object.create(CWFB_HtmlWidget.prototype);