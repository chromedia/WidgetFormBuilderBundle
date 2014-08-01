var CWFB_HtmlWidgetFactory = (function($){
    return {
        buildFromJSON: function(jsonString) {
            var metadata = window.JSON.parse(jsonString);
            
            if (!metadata.widget_id) {
                throw "CWFB_HtmlWidgetFactory: widget_id is required ";
            }
            
            switch (metadata.widget_id) {
                case 'choice':
                    var widget = new CWFB_ChoiceWidget(metadata);
                    widget.build();
                    break;
                case 'text':
                    break;
                default:
                    throw "CWFB_HtmlWidgetFactory: Unknown widget_id ["+metadata.widget_id+"]"
                    break;
            }
         
            return widget;
        }
    }
})(jQuery);