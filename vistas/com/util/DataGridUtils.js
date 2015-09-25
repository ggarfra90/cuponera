/* 
 * @version 1.0
 * @copyright (c) 2013, IMAGINA TECHNOLOGIES S.A.C.
 * 
 * @abstract JSScript Donde se ubicar los metodos utilitarios para el manejo de Datagrids
 */

//-- Formatter Genéricos del DataGrid --
$.fn.datagrid.formatters = 
{
    default: function (value, row, index) {
        return value;
    },
    jplotGraph: function (value, row, index) {
        var columnExtendedPropierties = {
            autoSizeRow: true,
            autoSizeFooter: true,
            rowHeight: null,
            rowWidth: null,
            footerHeight: null,
            footerWidth: null,
            showLoading: false
        };
        var canvasLinePropierties = {
            lineWidth: 1.5,
            color: '#000000',
            lineCap: 'square',
            yOffset: 0,
            shadow: true,
            shadowDepth: 3
        };
        var graphType = {
            bar: "bar",
            line: "line",
            curve: "curve"
        };
        var canvasLineType = {
            solid: "solid",
            dash: "dash"
        }; 

        if (isEmpty(value)) return '';
        if (!$.isPlainObject(value)) return '';
        
        var series = null, values = null, footer = null, vlines = null;
        if (hasPropiertyObject(value, 'series')) series = value.series;
        if (hasPropiertyObject(value, 'values')) values = value.values;
        if (hasPropiertyObject(value, 'footer')) footer = value.footer;
        if (hasPropiertyObject(value, 'vlines')) vlines = value.vlines;
        
        var column = getColumnExtended(this);
        var $container = $("<div>")
                            .css({
                                position: 'block',
                                overflow: 'hidden',
                                padding: 0,
                                margin: 0,
                                'vertical-align': 'middle',
                                'text-align': 'center'
                            });
        
        if (!isEmpty(footer))
        {
            if (column.autoSizeFooter)
            {
                $container.width(column.width).height('100%');
            }
            else
            {
                if (!isEmpty(column.footerWidth))
                {
                    $container.width(column.footerWidth);                        
                }
                else
                {
                    $container.width(column.width);
                }

                if (!isEmpty(column.footerHeight))
                {
                    $container.height(column.footerHeight);
                }
                else
                {
                    $container.height('100%');
                }
            }
        } 
        else 
        {        
            if (column.autoSizeRow)
            {
                $container.width(column.width).height('100%');
            }
            else
            {
                if (!isEmpty(column.rowWidth))
                {
                    $container.width(column.rowWidth);
                }
                else
                {
                    $container.width(column.width);
                }

                if (!isEmpty(column.rowHeight))
                {
                    $container.height(column.rowHeight);
                }
                else
                {
                    $container.height('100%');
                }
            }
        }
        
        var code = generateCode();
        var field = column.field;
        var graphContainerId = (isEmpty(field) ? 'column' : String(field).trim()) + (code + '-' + index);
        
        $container.prop('id', graphContainerId).attr('name', graphContainerId);
        
        setTimeout(function(){
            if (isEmpty(graphContainerId)) return;
            
            var $graphContainer = $('#'+graphContainerId);
            if (isEmpty($graphContainer)) return;
            if ($graphContainer.length === 0) return;
            
            var $cellContainer = $graphContainer.parent();
            if (!isEmpty($cellContainer) && $cellContainer.length > 0)
            {
                $cellContainer.css({
                                    'padding-left': 15,
                                    'padding-right': 15,
                                    'padding-top': 5,
                                    'padding-bottom': 5,
                                    'vertical-align': 'middle',
                                    'text-align': 'center'
                                });
                
                $graphContainer.width ($graphContainer.width() - 30);
                $graphContainer.height ($graphContainer.height() - 30);
                
                if (column.showLoading) Loading.show($cellContainer);
            }
            else
            {
                if (column.showLoading) Loading.show($graphContainer);
            }
            
            var jplotSeries = new Array();
            var jplotValues = new Array();
            var jplotXKeys = new Array();
            var jplotTicks = new Array();
            
            if (!isEmpty(footer))
            {
                jplotSeries = [{
                    skey : "footer",
                    label: "footer",
                    color: "#FFFFFF"
                }];
            
                if (footer.length > 0)
                {
                    jplotSerieValues =  new Array();
                    
                    for(var i = 0; i < footer.length; i++)
                    {
                        var footerValue = footer[i];
                        var jplotSerieValue = new Array();
                        var label = "";
                        var value = 100;
                        
                        if (!isEmpty(footerValue))
                        {
                            if (hasPropiertyObject(footerValue, 'label') && String(footerValue.label).trim().length > 0)
                            {
                                label = String(footerValue.label).trim();
                            }

                            if (hasPropiertyObject(footerValue, 'value') && String(footerValue.value).trim().length > 0 && $.isNumeric(String(footerValue.value).trim()))
                            {
                                value = parseFloat(String(footerValue.value).trim());
                            }
                        }

                        jplotSerieValue.push(label);
                        jplotSerieValue.push(value);
                        jplotSerieValues.push(jplotSerieValue);
                    }
                    
                    jplotValues.push(jplotSerieValues);
                }
            }
            else if (!isEmpty(series) && !isEmpty(values))
            {
                if (series.length > 0)
                {
                    var randomColors = getHexaColors(series.length);
                    
                    for(var i = 0; i < series.length; i++)
                    {
                        var serie = series[i];
                        if (isEmpty(serie)) continue;
                        
                        var jplotSerie = new Object();
                        jplotSerie.skey = "serie-" + i.toString();
                        jplotSerie.type = graphType.line;
                        jplotSerie.rendererOptions = {
                            animation: {
                                show: true,
                                speed: 3000
                            }
                        };
                        
                        if (hasPropiertyObject(serie, 'skey') && String(serie.skey).trim().length > 0)
                        {
                            jplotSerie.skey = String(serie.skey).trim();
                        }
                        
                        if (hasPropiertyObject(serie, 'type') && String(serie.type).trim().toLowerCase() === graphType.bar)
                        {
                            jplotSerie.renderer = $.jqplot.BarRenderer;
                            jplotSerie.type = graphType.bar;
                        }
                        else
                        {
                            jplotSerie.rendererOptions = {
                                breakOnNull: false,
                                smooth: false
                            };
                            
                            if (hasPropiertyObject(serie, 'type') && String(serie.type).trim().toLowerCase() === graphType.curve)
                            {
                                jplotSerie.type = graphType.curve;
                                jplotSerie.rendererOptions.smooth = true;
                                jplotSerie.rendererOptions.constrainSmoothing = false;
                            }
                        }
                        
                        if (hasPropiertyObject(serie, 'label') && String(serie.label).trim().length > 0)
                        {
                            jplotSerie.label = String(serie.label).trim();
                        }
                        
                        if (hasPropiertyObject(serie, 'color') && String(serie.color).trim().length > 0 && isHexColor(String(serie.color).trim()))
                        {
                            jplotSerie.color = String(serie.color).trim();
                        }
                        else if (!isEmpty(randomColors) && randomColors.length > 0 && !isEmpty(randomColors[i]))
                        {
                            jplotSerie.color = randomColors[i];
                        }
                        
                        jplotSeries.push(jplotSerie);
                    }
                }
                
                if (jplotSeries.length > 0 && !$.isEmptyObject(values))
                {
                    for(var i = 0; i < jplotSeries.length; i++)
                    {
                        var jplotSerie = jplotSeries[i];
                        var skey = jplotSerie.skey;
                        var jplotSerieValues = new Array();
                        
                        if (!isEmpty(skey) && hasPropiertyObject(values, skey))
                        {
                            var serieValues = values[skey];
                            if (!isEmpty(serieValues))
                            {
                                for (var j = 0; j < serieValues.length; j++)
                                {
                                    var serieValue = serieValues[j];
                                    var jplotSerieValue = new Array();
                                    var label = "";
                                    var value = null;
                                    var xkey = "xaxis-" + j.toString();
                                    
                                    if (!isEmpty(serieValue))
                                    {
                                        if (hasPropiertyObject(serieValue, 'xkey') && String(serieValue.xkey).trim().length > 0)
                                        {
                                            xkey = String(serieValue.xkey).trim();
                                        }
                                        
                                        if (hasPropiertyObject(serieValue, 'label') && String(serieValue.label).trim().length > 0)
                                        {
                                            label = String(serieValue.label).trim();
                                        }
                                        
                                        if (hasPropiertyObject(serieValue, 'value') && String(serieValue.value).trim().length > 0 && $.isNumeric(String(serieValue.value).trim()))
                                        {
                                            value = parseFloat(String(serieValue.value).trim());
                                        }
                                    }
                                    
                                    if (jplotSeries.length > 1)
                                    {
                                        jplotSerieValue.push(label);
                                        jplotSerieValue.push(value);
                                        jplotSerieValues.push(jplotSerieValue);
                                    }
                                    else if (jplotSeries.length === 1)
                                    {
                                        jplotSerieValues.push(value);
                                    }
                                    
                                    if (jplotXKeys.indexOf(xkey) < 0)
                                    {
                                        jplotXKeys.push(xkey);
                                        jplotTicks.push(label);
                                    }
                                }
                            }
                        }
                        
                        jplotValues.push(jplotSerieValues);
                    }
                }
            }
            
            if (!isEmpty(jplotSeries) && !isEmpty(jplotValues))
            {
                var jplotOption = new Object();
                jplotOption.animate = true;
                jplotOption.animateReplot = true;
                jplotOption.seriesDefaults = {
                    allowNullableValues: true,
                    useNegativeColors: false,
//                    pointLabels: {
//                        show: true
//                    },
                    rendererOptions: {
                        fillToZero: true,
                        highlightMouseOver: true
                    }
                };
                jplotOption.series = jplotSeries;
                jplotOption.axes = {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer
                    },
                    yaxis: {
                        autoscale:true
                    }
                };
                jplotOption.highlighter = {
                    show: true,
                    sizeAdjust: 2,
                    tooltipOffset: 9,
                    useLabelsAxisX: true,
                    tooltipContentEditor: highlighterContentEditor                 
                };
                
                if (jplotSeries.length === 1 && !isEmpty(series) && !isEmpty(values))
                {
                    jplotOption.axes.xaxis.ticks = jplotTicks;
                }
                
                var canvasLines = new Array();
                
                if (isEmpty(footer) && !isEmpty(vlines) && vlines.length > 0)
                {
                    for(var i = 0; i < vlines.length; i++)
                    {
                        var vline = vlines[i];                        
                        if (isEmpty(vline) || $.isEmptyObject(vline)) continue;
                        if (!hasPropiertyObject(vline, 'xkey')) continue;
                        if (String(vline.xkey).trim().length === 0) continue;
                        
                        var xkey = String(vline.xkey).trim();
                        if (jplotXKeys.indexOf(xkey) < 0) continue;
                        
                        var propierties = new Object();
                        propierties.name = xkey;
                        propierties.x = jplotXKeys.indexOf(xkey) + 1;
                        
                        var type = canvasLineType.solid;
                        if (hasPropiertyObject(vline, 'type') && String(vline.type).trim().toLowerCase() === canvasLineType.dash)
                        {
                            type = canvasLineType.dash;
                        }                        
                        if (hasPropiertyObject(vline, 'width') && String(vline.width).trim().length > 0 && $.isNumeric(String(vline.width).trim()))
                        {
                            propierties.lineWidth = parseFloat(String(vline.width).trim());
                        }                        
                        if (hasPropiertyObject(vline, 'color') && String(vline.color).trim().length > 0 && isHexColor(String(vline.color).trim()))
                        {
                            propierties.color = String(vline.color).trim();
                        }
                        if (hasPropiertyObject(vline, 'shadow') && $.type(vline.shadow) === JSType.BOOLEAN)
                        {
                            propierties.shadow = vline.shadow;
                        }
                        if (hasPropiertyObject(vline, 'shadowAngle') && String(vline.shadowAngle).trim().length > 0 && $.isNumeric(String(vline.shadowAngle).trim()))
                        {
                            propierties.shadowAngle = parseFloat(String(vline.shadowAngle).trim());
                        }
                        if (hasPropiertyObject(vline, 'shadowOffset') && String(vline.shadowOffset).trim().length > 0 && $.isNumeric(String(vline.shadowOffset).trim()))
                        {
                            propierties.shadowOffset = parseFloat(String(vline.shadowOffset).trim());
                        }
                        if (hasPropiertyObject(vline, 'shadowDepth') && String(vline.shadowDepth).trim().length > 0 && $.isNumeric(String(vline.shadowDepth).trim()))
                        {
                            propierties.shadowDepth = parseFloat(String(vline.shadowDepth).trim());
                        }
                        if (hasPropiertyObject(vline, 'shadowAlpha') && String(vline.shadowAlpha).trim().length > 0 && $.isNumeric(String(vline.shadowAlpha).trim()))
                        {
                            propierties.shadowAlpha = parseFloat(String(vline.shadowAlpha).trim());
                        }
                        
                        propierties = $.extend(true, {}, canvasLinePropierties, propierties);
                        
                        if (type === canvasLineType.solid)
                        {
                            canvasLines.push ({ verticalLine:  propierties});
                        }
                        else if (type === canvasLineType.dash)
                        {
                            canvasLines.push ({ dashedVerticalLine:  propierties});
                        }
                    }
                }
                
                if (!isEmpty(canvasLines) && canvasLines.length > 0)
                {
                    jplotOption.canvasOverlay = {
                        show: true,
                        objects: canvasLines
                    };
                }
                
                $.jqplot(graphContainerId, jplotValues, jplotOption);
            }
            
            if (!isEmpty(footer))
            {
                $graphContainer.children().each(function(){
                    var $this = $(this);
                    
                    if ($this.hasClass("jqplot-xaxis"))
                    {
                        $this.css('bottom','');
                    }
                    else if ($this.hasClass("jqplot-grid-canvas"))
                    {
                        var $xaxis = $graphContainer.children(".jqplot-xaxis");
                        if (!isEmpty($xaxis) && $xaxis.length > 0)
                        {
                            var thisHeight = $this.height();
                            var xaxisHeight = $xaxis.height();
                            var xaxisMarginTop = $xaxis.css("margin-top");
                            var xaxisMarginBottom = $xaxis.css("margin-bottom");
                            
                            var xaxisDiff = xaxisHeight;
                            
                            var newTop = 0;
                            if (xaxisHeight / thisHeight <= 0.40)
                            {
                                if (!isEmpty(xaxisMarginTop)) xaxisDiff += parseFloat(String(xaxisMarginTop).replace("px",""));
                                if (!isEmpty(xaxisMarginBottom)) xaxisDiff += parseFloat(String(xaxisMarginBottom).replace("px",""));
                                
                                xaxisDiff += 5;
                                
                                newTop = xaxisDiff - thisHeight;
                            }
                            else
                            {
                                newTop = -1 * (0.40 * thisHeight - 5);
                            }
                            
                            $this.css("top", newTop + "px");
                            
                            if (column.autoSizeFooter || (!column.autoSizeFooter && isEmpty(column.footerHeight)))
                            {
                                $graphContainer.height(xaxisDiff);
                            }
                        }
                        else
                        {
                            $this.remove();
                        }
                    }
                    else
                    {
                        $this.remove();
                    }
                });
            }
            else if (!isEmpty(series) && !isEmpty(values))
            {
                var $xaxis = $graphContainer.children(".jqplot-xaxis");
                var xaxisHeight = $xaxis.height();
                var graphHeight = $graphContainer.height();
                
                $graphContainer.children(".jqplot-xaxis").each(function(){
                    $(this).remove();
                });
                
                $graphContainer.height(graphHeight - xaxisHeight);
            }
            
            setTimeout(function (){
                var $graphContainer = $('#'+graphContainerId);
                var $dgView = $graphContainer.parents("div.datagrid-view");
                if (!isEmpty($dgView) && $dgView.length > 0)
                {
                    var $dg = $dgView.children('table');
                    if (!isEmpty($dg) && $dg.length > 0)
                    {
                        if ( (column.autoSizeRow || column.autoSizeFooter) 
                          || (!column.autoSizeRow && (isEmpty(column.rowHeight) || isEmpty(column.rowWidth)))
                          || (!column.autoSizeFooter && (isEmpty(column.footerHeight) || isEmpty(column.footerWidth)))
                           )
                        {
                            $dg.datagrid('resize');
                        }
                    }
                }
                
                var $cellContainer = $graphContainer.parent();
                if (!isEmpty($cellContainer) && $cellContainer.length > 0)
                {
                    if (column.showLoading) Loading.close($cellContainer);
                }
                else
                {
                    if (column.showLoading) Loading.close($graphContainer);
                }
            }, 0);
        }, 0);
        
        return $container.get(0).outerHTML;
        
        function getColumnExtended (obj)
        {
            var column = $.extend(true, {}, columnExtendedPropierties, obj || {});
        
            if (isEmpty(column.autoSizeRow) || $.type(column.autoSizeRow) !== JSType.BOOLEAN)
            {
                column.autoSizeRow = columnExtendedPropierties.autoSizeRow;
            }
            if (isEmpty(column.autoSizeFooter) || $.type(column.autoSizeFooter) !== JSType.BOOLEAN)
            {
                column.autoSizeFooter = columnExtendedPropierties.autoSizeFooter;
            }
            if (isEmpty(column.rowHeight) || ($.type(column.rowHeight) !== JSType.NUMBER && $.type(column.rowHeight) !== JSType.STRING))
            {
                column.rowHeight = columnExtendedPropierties.rowHeight;
            }
            if (isEmpty(column.rowWidth) || ($.type(column.rowWidth) !== JSType.NUMBER && $.type(column.rowWidth) !== JSType.STRING))
            {
                column.rowWidth = columnExtendedPropierties.rowWidth;
            }
            if (isEmpty(column.footerHeight) || ($.type(column.footerHeight) !== JSType.NUMBER && $.type(column.footerHeight) !== JSType.STRING))
            {
                column.footerHeight = columnExtendedPropierties.footerHeight;
            }
            if (isEmpty(column.footerWidth) || ($.type(column.footerWidth) !== JSType.NUMBER && $.type(column.footerWidth) !== JSType.STRING))
            {
                column.footerWidth = columnExtendedPropierties.footerWidth;
            }
            if (isEmpty(column.showLoading) || $.type(column.showLoading) !== JSType.BOOLEAN)
            {
                column.showLoading = columnExtendedPropierties.showLoading;
            }

            return column;
        }
        
        function isHexColor(string)
        {
            return /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(string);
        }
        
        function highlighterContentEditor (str, seriesIndex, pointIndex, plot)
        {
            if (!isEmpty(seriesIndex) && !isEmpty(plot) && !isEmpty(plot.series))
            {
                if (seriesIndex < plot.series.length)
                {
                    var serie = plot.series[seriesIndex];
                    
                    if (!isEmpty(serie) && !isEmpty(serie.label) && String(serie.label).trim().length > 0)
                    {
                        if (isEmpty(str))
                            str = String(serie.label).trim();
                        else
                            str = String(serie.label).trim() + " [" + str + "]";
                    }
                }
            }
            
            return str;
        }
    }
};

//-- Métogos Génericos del DataGrid --
$.extend($.fn.datagrid.methods, {
    enableEditor:function(jq, _53b) {
        function find(_53c) {
            if (_53c) {
                for (var i = 0; i < _53c.length; i++) {
                    var cc = _53c[i];
                    for (var j = 0; j < cc.length; j++) {
                        var c = cc[j];
                        if (c.field === _53b) {
                            return c;
                        }
                    }
                }
            }
            return null;
        }
        ;
        var opts = $.data(jq[0], "datagrid").options;
        var col = find(opts.columns);
        if (!col) {
            col = find(opts.frozenColumns);
        }
        if(col) {
            col.disableEditor = false;
        }
        
        return col;
    },
    disableEditor:function(jq, _53b) {
        function find(_53c) {
            if (_53c) {
                for (var i = 0; i < _53c.length; i++) {
                    var cc = _53c[i];
                    for (var j = 0; j < cc.length; j++) {
                        var c = cc[j];
                        if (c.field === _53b) {
                            return c;
                        }
                    }
                }
            }
            return null;
        }
        ;
        var opts = $.data(jq[0], "datagrid").options;
        var col = find(opts.columns);
        if (!col) {
            col = find(opts.frozenColumns);
        }
        if(col) {
            col.disableEditor = true;
        }
        
        return col;
    },
    expandGroup:function(jq, groupIndex){
        return jq.each(function(){
            var view = $.data(this, 'datagrid').dc.view;
            if (groupIndex!=undefined){
                var group = view.find('div.datagrid-group[group-index="'+groupIndex+'"]');
            } else {
                var group = view.find('div.datagrid-group');
            }
            var expander = group.find('div.datagrid-row-expander');
            if (expander.hasClass('datagrid-row-expand')){
                expander.removeClass('datagrid-row-expand').addClass('datagrid-row-collapse');
                group.next('table').show();
            }
            $(this).datagrid('fixRowHeight');
        });
    },
    collapseGroup:function(jq, groupIndex){
        return jq.each(function(){
            var view = $.data(this, 'datagrid').dc.view;
            if (groupIndex!=undefined){
                var group = view.find('div.datagrid-group[group-index="'+groupIndex+'"]');
            } else {
                var group = view.find('div.datagrid-group');
            }
            var expander = group.find('div.datagrid-row-expander');
            if (expander.hasClass('datagrid-row-collapse')){
                expander.removeClass('datagrid-row-collapse').addClass('datagrid-row-expand');
                group.next('table').hide();
            }
            $(this).datagrid('fixRowHeight');
        });
    }
});

//-- Editores Génericos del DataGrid --
$.extend($.fn.datagrid.defaults.editors, {
    edBuscaPersona: {  
        init: function(container, options) {
            var id =  Math.floor((Math.random()*10000)+1); 
            var dvId = 'dvBuscaPersona' + id;
            var input = $('<div id="' + dvId + '"></div>').appendTo(container);  
            var width = $("#" + dvId).width();
            var buscapersona = new BuscaPersona(dvId, options.empresa_id);
            if(!isEmpty(options)) {
                if(!isEmpty(options.opcional)) buscapersona.setOpcional(options.opcional);
                if(!isEmpty(options.espaciotrabajo_id)) buscapersona.setEspacioTrabajoId(options.espaciotrabajo_id);
                if(!isEmpty(options.componenteinstancia_id)) buscapersona.setComponenteInstanciaId(options.componenteinstancia_id);
                if(!isEmpty(options.modo_id)) buscapersona.setModoId(options.modo_id);
                if(!isEmpty(options.tipo_id)) buscapersona.setTipoId(options.tipo_id);
            }
            buscapersona.setWidth(width);
            buscapersona.load();
            return buscapersona;  
        },  
        getValue: function(target){  
            return $(target)[0].getItemSeleccionado();
        },  
        setValue: function(target, value) {
            $(target)[0].setItemSeleccionado(value);
            $(target)[0].reload();
        },
        resize: function(target, width) {
            var input = $(target);
            if ($.boxModel == true){
                input.width(width - (input.outerWidth() - input.width()));
            } else {
                input.width(width);
            }
        }
    },
    edSbsComboBox: {
        init: function(container, options) {
            var id =  Math.floor((Math.random()*10000)+1); 
            var dvId = 'dvComboBox' + id;
            var input = $('<div id="' + dvId + '"></div>').appendTo(container);
            var width = $("#" + dvId).width();
            var cmb = new SbsComboBox(dvId, 'cmb' + id);
            if(!isEmpty(options)) {
                if(!isEmpty(options.dataCombo)) cmb.setDataCombo(options.dataCombo);
                if(!isEmpty(options.opcional)) cmb.setOpcional(options.opcional);
                if(!isEmpty(options.textField)) cmb.setTextField(options.textField);
            }
            cmb.setWidth(width);
            cmb.setPanelWidth('auto');
            cmb.setPanelHeight('auto');
            cmb.setPanelMaxHeight(200);
            if(!isEmpty(options.onChangeFunction))cmb.addEventListener('change', options.onChangeFunction);
            cmb.load();
            return cmb;
        },
        getValue: function(target) {
            return $(target)[0].getItemSeleccionado();
        },
        setValue: function(target, value) {
            $(target)[0].setItemSeleccionado(value);
            $(target)[0].reload();
        },
        resize: function(target, width) {
            var input = $(target);
            if ($.boxModel == true) {
                input.width(width - (input.outerWidth() - input.width()));
            } else {
                input.width(width);
            }
        }
    },
    edSbsFechaHora: {
        init: function(container, options) {
            var id =  Math.floor((Math.random()*10000)+1); 
            var dvId = 'dvFechaHora' + id;
            var input = $('<div id="' + dvId + '"></div>').appendTo(container);
            var horaOpcional = false;
            var fechaHoraOpcional = false;
            if(!isEmpty(options)) {
                if(!isEmpty(options.horaOpcional)) horaOpcional = options.horaOpcional;
                if(!isEmpty(options.fechaHoraOpcional)) fechaHoraOpcional = options.fechaHoraOpcional;
            }
            var fecha = new SbsFechaHora(dvId, 'fechahora' + id, '', false, horaOpcional, true, '', fechaHoraOpcional);
            fecha.load();
            return fecha;
        },
        getValue: function(target) {
            return $(target)[0].getValor();
        },
        setValue: function(target, value) {
            $(target)[0].setValor(value);
            $(target)[0].setValueChkFechaYHoraOpcional(true); // Para forzar q habilite el check =/ =S.
            $(target)[0].reload();
        },
        resize: function(target, width){  
            var input = $(target);  
            if ($.boxModel == true) {
                input.width(width - (input.outerWidth() - input.width()));
            } else {
                input.width(width);
            }
        }
    },
    edSbsValidateInputText : {
        init: function(container, options) {
            var id =  Math.floor((Math.random()*10000)+1); 
            var inputId = 'sbsInputText' + id;
            var input = $('<input id="' + inputId + '" type="text" class="datagrid-editable-input">').appendTo(container);
            input.css({ position: 'block', 'vertical-align': 'middle'});
            
            if (!isEmpty(options.maxlength) && trim(options.maxlength).length > 0)
            {   
                input.attr('maxlength', options.maxlength);
            } 
            else if (!isEmpty(options.maxLength) && trim(options.maxLength).length > 0)
            {
                input.attr('maxlength', options.maxLength);
            }
            
            var validateOptions = { };
            if (!isEmpty(options.required) && trim(options.required).length > 0)
            {
                validateOptions.required = options.required;
            }
            
            if (!isEmpty(options.validType) && trim(options.validType).length > 0)
            {
                validateOptions.validType = options.validType;
            }
            
            if (isEmptyObject(validateOptions))
            {
                input.validatebox ();
            }
            else
            {
                input.validatebox (validateOptions);
            }
            
            return input;
        },
        getValue: function(target) {
            return $(target).val();
        },
        setValue: function(target, value) {
            $(target).val(value);
        },
        resize: function(target, width){  
            var input = $(target);  
            if ($.boxModel === true) {
                input.width(width - (input.outerWidth() - input.width()) - 6);
            } else {
                input.width(width - 6);
            }
        }
    }
});