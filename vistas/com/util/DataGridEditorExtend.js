/* 
 * @author: Christopher Heredia Lozada
 */
var ext = 0;
$.extend($.fn.datagrid.defaults.editors, {
    kendoMultiSelect: {
        init: function(container, options){
            ext += 1;
            var nameElemento = 'filter'+ext;
            $('<input type="textbox" id="'+nameElemento+'">').appendTo(container);
            $("#"+nameElemento).kendoMultiSelect(options);
            var multiSelect = $("#"+nameElemento).data("kendoMultiSelect");
            multiSelect._container = container;
            return multiSelect;
        },
        destroy: function(target){
            target.destroy();
        },
        getValue: function(target){
            return ($.type(target.dataItems()) === 'array' && target.dataItems().length > 0) ? target.dataItems()[0][target.options.dataValueField] :"";
        },
        setValue: function(target, value){
            target.value([value]);
        },
        resize: function(target, width){
            //target[0];
        }
    },
    textboxp: {
        init: function(container, options){
            var indexRow = getRowIndex(container);
            var name = "textbox" + indexRow;
            var input = $('<input type="textbox" id="'+name+'" name="'+name+'">').appendTo(container);
            options.fileOC = {
                nombre: $('#dg_cotizacion').datagrid('getRows')[indexRow]["oc_nombre"],
                url: $('#dg_cotizacion').datagrid('getRows')[indexRow]["oc_url"],
                extension: $('#dg_cotizacion').datagrid('getRows')[indexRow]["oc_extension"]
            };
            $("#"+name).textbox(options);
            return input;
        },
        destroy: function(target){
            $(target).remove();
        },
        getValue: function(target){
            return $(target).textbox('getValue');
        },
        setValue: function(target, value){
            $(target).textbox('setValue',value);
        },
        resize: function(target, width){
            $(target)._outerWidth(width);
        }
    }
});