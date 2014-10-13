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
    switch(this.widgetId) {
        case 'radio':
        case 'checkbox':
            if (this.widgetChoices.length > 0) {
                var widget = this.el;
                var div = document.createElement('div')

                this.widgetChoices.forEach(function(item) {
                    var choice = widget.cloneNode(false);
                    choice.value = item;
                    
                    var label = document.createElement('label');
                    label.appendChild(document.createTextNode(item));

                    div.appendChild(choice);
                    div.appendChild(label);
                });

                this.el = div.childNodes;
            }

            break;
        case 'choice':
            var elDom = this.el;
    
            this.widgetChoices.forEach(function(item) {
                var opt = document.createElement('option');
                opt.appendChild(document.createTextNode(item));
                
                elDom.appendChild(opt);
            });

            break;
    }

    return this;
};


CWFB_HtmlWidget.prototype._buildAttributes = function() {
    var elDom = this.el;

    this.widgetAttributes.forEach(function(item, key){
        for (attributeName in item) {}

        if (attributeName) {
            if( Object.prototype.toString.call( elDom ) === '[object NodeList]' ) {
                var nodes = elDom;

                for(var i = 0; i < nodes.length; i++) {
                    if (nodes[i].tagName == 'input') {
                        nodes[i].setAttribute(attributeName, item[attributeName]);
                    }
                }
            } else {
                elDom.setAttribute(attributeName, item[attributeName]);
            }
        }
    });
    
    return this;
};

