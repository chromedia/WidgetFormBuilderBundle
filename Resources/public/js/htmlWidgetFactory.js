var CWFB_HtmlWidgetFactory = (function($){
    return {
        buildFromJSON: function(metadata) {
            
            if(typeof metadata == 'string') {
                try {
                    metadata = function(str) {
                        return (str + '').replace(/[\\]/g, '\\$&').replace(/\u0000/g, '\\0');
                    }(metadata);
                    metadata = window.JSON.parse(metadata);
                }
                catch (e) {
                    throw "CWFB_HtmlWidgetFactory: jsonString is not valid.";
                }                
            }
            
            if (!metadata.widget_id) {
                throw "CWFB_HtmlWidgetFactory: widget_id is required.";
            }
            
            var baseWidgetPrototype = CWFB_AvailableWidgets.getByWidgetId(metadata.widget_id);
            
            if (!baseWidgetPrototype) {
                throw "CWFB_HtmlWidgetFactory: Unknown widget_id, unable to build prototype.";
            }
            
            var widget = new CWFB_HtmlWidget(metadata, baseWidgetPrototype.html);
            widget.build();
         
            return widget;
        }
    }
})(jQuery);
