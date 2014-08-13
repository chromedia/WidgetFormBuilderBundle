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
                case 'checkbox':
                    var widget = new CWFB_CheckboxWidget(metadata);
                    widget.build();
                    break;
                case 'radio':
                    var widget = new CWFB_RadioButtonWidget(metadata);
                    widget.build();
                    break;
                case 'textarea':
                    var widget = new CWFB_TextareaWidget(metadata);
                    widget.build();
                    break;
                case 'text':
                    var widget = new CWFB_TextWidget(metadata);
                    widget.build();
                    break;
                case 'date':
                    var widget = new CWFB_DateWidget(metadata);
                    widget.build();
                    break;
                case 'file':
                    var widget = new CWFB_FileWidget(metadata);
                    widget.build();
                    break;
                default:
                    throw "CWFB_HtmlWidgetFactory: Unknown widget_id ["+metadata.widget_id+"]"
                    break;
            }
         
            return widget;
        }
    }
})(jQuery);