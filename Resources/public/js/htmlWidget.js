if (jQuery) {
    var CWFB_jQueryUtility = (function(){
        return {
            htmlStringToDOM: function(s) {
                var _el = $(s);
                return _el[0];
            },
        };
    })(jQuery);
}


var CWFB_HtmlWidget = function(metadata, prototypeHtml){
    this.prototypeHtml = prototypeHtml;
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
    this.el = CWFB_jQueryUtility.htmlStringToDOM(this.prototypeHtml);
};

CWFB_HtmlWidget.prototype._buildChoices = function() {
    return this;
};

CWFB_HtmlWidget.prototype._buildAttributes = function() {
    var elDom = this.el;

    this.widgetAttributes.forEach(function(item, key){
        for (attributeName in item) {}

        if (attributeName) {
            var inputTags = elDom.querySelectorAll('input, textarea, select');

            if (inputTags && inputTags.length > 0) {
                for(var ctr = 0; ctr < inputTags.length; ctr++) {
                    inputTags[ctr].setAttribute(attributeName, item[attributeName]);
                }
            } else {
                elDom.setAttribute(attributeName, item[attributeName]);
            }
        }
    });
    
    return this;
};

