$.extend($.fn.validatebox.methods,{
    setRequired:function(jq,required){
        $.data(jq[0],"validatebox").options.required = required;
    },
    getRequired:function(jq){
           return $.data(jq[0],"validatebox").options.required;
    },
    getValue:function(jq){
           return $.data(jq[0],"validatebox").value;
    },
    setValue:function(jq,value){
           jq[0].value = value;
           $.data(jq[0],"validatebox").value = value;
    }
});

$.extend($.fn.validatebox.defaults.rules, {  
    minLength: {  
        validator: function(value, param){  
            return value.length >= param[0];  
        },  
        message: 'Debe ingresar al menos {0} caracteres.'  
    },
    curvasDisponibles: {
        validator: function(value, param){
            if(parseInt(value) === 1) {
                param[0] = 'Configure al menos una curva.';
            } else if(parseInt(value) === 2) {
                param[0] = 'Existen configuraciones incorrectas en algunas curvas. Por favor corregir para continuar.';
            }
            return parseInt(value) === 0;
        },
        message: '{0}'
    },
    numbersRange: {  
        validator: function(value, param) {
            return (value >= param[0] && value <= param[1]);
        },  
        message: 'Ingrese un valor entre {0} y {1}.'  
    },      
    maxLength: {  
        validator: function(value, param){  
            return value.length <= param[0];  
        },
        message: 'Debe ingresar hasta {0} caracteres como máximo.'
    },
    maxLengthTextArea:
        {  
        validator: function(value, param){
            var saltoLineas = value.match(/\n/g);
            var contSaltos = (!isEmpty(saltoLineas))?saltoLineas.length:0;
            var length = value.length + contSaltos;
            param[1] = length;
            return length <= param[0] - 10;
        },
        message: 'Solo puede ingresar {0} como maximo ({1}/{0})'
    },
    isInteger: {
        validator: function (value, param){
           if (isEmpty(value)) return true;
            
            var matchRegExpParam = new Array();
            
            matchRegExpParam.push ($.fn.validatebox.defaults.rules.isInteger.getPatron('integer'));
            matchRegExpParam.push ($.fn.validatebox.defaults.rules.isInteger.getErrorMessage('integer', param));
            
            var result = $.fn.validatebox.defaults.rules.matchRegExp.validator (value, matchRegExpParam);
            $.fn.validatebox.defaults.rules.isInteger.message = $.fn.validatebox.defaults.rules.matchRegExp.message;
            
            return result;
        },
        message: '',
        getErrorMessage: function (type, param) {
            if (isEmpty(type)) return null;
            
            var msg_error = 'Debe ser un número';
            
            switch (trim(type).toLowerCase())
            {
                case 'integer': msg_error = 'Debe ser un número entero.'; break;
                case 'unsignedinteger': msg_error = 'Debe ser un número entero sin signo.'; break;
                case 'signedinteger': msg_error = 'Debe ser un número entero con signo o sin signo.'; break;
            }
            
            if (!isEmpty(param) && param.length >= 1 && !isEmpty(param[0]))
            {
                msg_error = trim(param[0]);
            }
            
            return msg_error;
        },
        getPatron: function (type) {
            if (isEmpty(type)) return null;
            
            var patron = null;
            
            switch (trim(type).toLowerCase())
            {
                case 'integer':
                    patron = /^-?\d+$/;
                    break;
                case 'unsignedinteger': 
                    patron = /^\d+$/;
                    break;
                case 'signedinteger': 
                    patron = /^(\+|-)?\d+$/;
                    break;
            }
            
            return patron;
        }
    },
    isUnsignedInteger: {
        validator: function (value, param){
           if (isEmpty(value)) return true;
            
            var matchRegExpParam = new Array();
            
            matchRegExpParam.push ($.fn.validatebox.defaults.rules.isInteger.getPatron('unsignedinteger'));
            matchRegExpParam.push ($.fn.validatebox.defaults.rules.isInteger.getErrorMessage('unsignedinteger', param));
            
            var result = $.fn.validatebox.defaults.rules.matchRegExp.validator (value, matchRegExpParam);
            $.fn.validatebox.defaults.rules.isUnsignedInteger.message = $.fn.validatebox.defaults.rules.matchRegExp.message;
            
            return result;
        },
        message: ''      
    },
    isSignedInteger: {
        validator: function (value, param){
           if (isEmpty(value)) return true;
            
            var matchRegExpParam = new Array();
            
            matchRegExpParam.push ($.fn.validatebox.defaults.rules.isInteger.getPatron('signedinteger'));
            matchRegExpParam.push ($.fn.validatebox.defaults.rules.isInteger.getErrorMessage('signedinteger', param));
            
            var result = $.fn.validatebox.defaults.rules.matchRegExp.validator (value, matchRegExpParam);
            $.fn.validatebox.defaults.rules.isSignedInteger.message = $.fn.validatebox.defaults.rules.matchRegExp.message;
            
            return result;
        },
        message: ''      
    },
    isDecimal: {
        validator: function (value, param) {
           if (isEmpty(value)) return true;
            
            var matchRegExpParam = new Array();
            
            var precision = $.fn.validatebox.defaults.rules.isDecimal.getPrecision(param);
            var msg_error = $.fn.validatebox.defaults.rules.isDecimal.getErrorMessage('decimal', precision, param);
            var patron = $.fn.validatebox.defaults.rules.isDecimal.getPatron('decimal', precision);

            matchRegExpParam.push (patron);
            matchRegExpParam.push (msg_error);
            
            var result = $.fn.validatebox.defaults.rules.matchRegExp.validator (value, matchRegExpParam);
            $.fn.validatebox.defaults.rules.isDecimal.message = $.fn.validatebox.defaults.rules.matchRegExp.message;
            
            return result;
        },
        message: '',
        getPrecision: function (param) {
            var precision = null;
            
            if (!isEmpty(param) && param.length >= 1 && !isEmpty(param[0]) && $.isNumeric(param[0]))
            {
                precision = parseInt(param[0]);
            }
            
            return precision;
        },
        getErrorMessage: function (type, precision, param) {
            if (isEmpty(type)) return null;
            
            var msg_error = 'Debe ser un número';
            
            switch (trim(type).toLowerCase())
            {
                case 'decimal': msg_error = 'Debe ser un número decimal'; break;
                case 'unsigneddecimal': msg_error = 'Debe ser un número decimal sin signo'; break;
                case 'signeddecimal': msg_error = 'Debe ser un número decimal con signo o sin signo'; break;
            }
            
            if (!isEmpty(param) && param.length >= 2 && !isEmpty(param[1]))
            {
                msg_error = trim(param[1]);
            }
            else
            {
                if (!isEmpty(precision))
                {
                    msg_error = msg_error + ' con precision de ' + precision + ' digitos';
                }
                
                msg_error = msg_error + '.';
            }
            
            return msg_error;
        },
        getPatron: function (type, precision) {
            if (isEmpty(type)) return null;
            
            var patron = null;
            
            if (!isEmpty(precision) && precision == 0)
            {
                switch (trim(type).toLowerCase())
                {
                    case 'decimal': patron = /^-?\d+$/; break;
                    case 'unsigneddecimal': patron = /^\d+$/; break;
                    case 'signeddecimal': patron = /^(\+|-)?\d+$/; break;
                }                
            } 
            else
            {
                switch (trim(type).toLowerCase())
                {
                    case 'decimal':
                        if (isEmpty(precision))
                        {
                           patron = /^(-?\d+)?(\.\d+|-\.\d+)?$/;
                        }
                        else
                        {
                            patron = "^(-?\\d+)?(\\.\\d{1,"+precision+"}|-\\.\\d{1,"+precision+"})?$";
                        }
                        break;
                    case 'unsigneddecimal': 
                        if (isEmpty(precision))
                        {
                           patron = /^(\d+)?(\.\d+)?$/;
                        }
                        else
                        {
                            patron = "^(\\d+)?(\\.\\d{1,"+precision+"})?$";
                        }
                        break;
                    case 'signeddecimal': 
                        if (isEmpty(precision))
                        {
                           patron = /^(-?\d+|\+?\d+)?(\.\d+|-\.\d+|\+\.\d+)?$/;
                        }
                        else
                        {
                            patron = "^(-?\\d+|\\+?\\d+)?(\\.\\d{1,"+precision+"}|-\\.\\d{1,"+precision+"}|\\+\\.\\d{1,"+precision+"})?$";
                        }
                        break;
                }
            }
            
            return patron;
        }
    },
    isUnsignedDecimal: {
        validator: function (value, param) {
           if (isEmpty(value)) return true;
            
            var matchRegExpParam = new Array();
            
            var precision = $.fn.validatebox.defaults.rules.isDecimal.getPrecision(param);
            var msg_error = $.fn.validatebox.defaults.rules.isDecimal.getErrorMessage('unsigneddecimal', precision, param);
            var patron = $.fn.validatebox.defaults.rules.isDecimal.getPatron('unsigneddecimal', precision);

            matchRegExpParam.push (patron);
            matchRegExpParam.push (msg_error);
            
            var result = $.fn.validatebox.defaults.rules.matchRegExp.validator (value, matchRegExpParam);
            $.fn.validatebox.defaults.rules.isUnsignedDecimal.message = $.fn.validatebox.defaults.rules.matchRegExp.message;
            
            return result;
        },
        message: ''
    },
    isSignedDecimal: {
        validator: function (value, param) {
           if (isEmpty(value)) return true;
            
            var matchRegExpParam = new Array();
            
            var precision = $.fn.validatebox.defaults.rules.isDecimal.getPrecision(param);
            var msg_error = $.fn.validatebox.defaults.rules.isDecimal.getErrorMessage('signeddecimal', precision, param);
            var patron = $.fn.validatebox.defaults.rules.isDecimal.getPatron('signeddecimal', precision);

            matchRegExpParam.push (patron);
            matchRegExpParam.push (msg_error);
            
            var result = $.fn.validatebox.defaults.rules.matchRegExp.validator (value, matchRegExpParam);
            $.fn.validatebox.defaults.rules.isSignedDecimal.message = $.fn.validatebox.defaults.rules.matchRegExp.message;
            
            return result;
        },
        message: ''
    },
    isHour : {
        validator: function (value, param) {
            if (isEmpty(value)) return true;
                        
            //-- Obtenemos los parámetros que configuran la validacion --
            var separatorSymbol = $.fn.validatebox.defaults.rules.isHour.getSeparatorSymbol(param);
            var withSeconds = $.fn.validatebox.defaults.rules.isHour.getWithSeconds(param);
            var is24Hours = $.fn.validatebox.defaults.rules.isHour.getIs24Hours(param);
            var minimum = $.fn.validatebox.defaults.rules.isHour.getMinimum(param);
            var maximum = $.fn.validatebox.defaults.rules.isHour.getMaximum(param);
            var messages = $.fn.validatebox.defaults.rules.isHour.getErrorMessage(param);
            
            //-- Verificamos que el mínimo no exceda del máximo --
            if ((!isEmpty(minimum) && !isEmpty(minimum.number)) && (!isEmpty(maximum) && !isEmpty(maximum.number)))
            {
                if (minimum.number >= maximum.number)
                {
                    minimum = $.fn.validatebox.defaults.rules.isHour.defaultNullHourObject;
                    maximum = $.fn.validatebox.defaults.rules.isHour.defaultNullHourObject;
                }
            }
            
            //-- En caso ser 24horas y no haber mínimo ni máximo entonces establecemos el rango 24 --
            if (is24Hours)
            {
                if (isEmpty(minimum) || isEmpty(minimum.number))
                {
                    minimum = $.fn.validatebox.defaults.rules.isHour.validateLimit($.fn.validatebox.defaults.rules.isHour.standardMinimumHourObject, param);
                }
                
                if (isEmpty(maximum) || isEmpty(maximum.number))
                {
                    maximum = $.fn.validatebox.defaults.rules.isHour.validateLimit($.fn.validatebox.defaults.rules.isHour.standardMaximumHourObject, param);
                }
            }
            
            var result = true, message = "";
            
            //-- Validamos el formato --
            var matchRegExpParam = new Array();
            var patron = null, formato = "";
            var regexpSymbol = parserStringToValidInRegExpPattern(separatorSymbol);
            if (withSeconds == true) 
            {
                if (is24Hours)
                {
                    patron = "^([0-9]|2[0-3]|[0-1][0-9])"+regexpSymbol+"([0-5][0-9])"+regexpSymbol+"([0-5][0-9])$";
                    formato = "hh"+separatorSymbol+"mm"+separatorSymbol+"ss";
                }
                else
                {
                    patron = "^(\\d+)"+regexpSymbol+"([0-5][0-9])"+regexpSymbol+"([0-5][0-9])$";
                    formato = "[h]"+separatorSymbol+"mm"+separatorSymbol+"ss";
                }
            }
            else
            {
                if (is24Hours)
                {
                    patron = "^([0-9]|2[0-3]|[0-1][0-9])"+regexpSymbol+"([0-5][0-9])$";
                    formato = "hh"+separatorSymbol+"mm";
                }
                else
                {
                    patron = "^(\\d+)"+regexpSymbol+"([0-5][0-9])$";
                    formato = "[h]"+separatorSymbol+"mm";
                }
            }
            
            //- Usamos el validador por expresión regular -
            matchRegExpParam.push (patron);
            if (is24Hours && !isEmpty(maximum.number) 
               && (     (withSeconds &&  maximum.number == $.fn.validatebox.defaults.rules.isHour.standardMaximumHourObject.number)
                    ||  (!withSeconds &&  maximum.integer == $.fn.validatebox.defaults.rules.isHour.standardMaximumHourObject.integer)
                  ))
            {
                matchRegExpParam.push (messages.msgNoFormat.replace('[FORMAT]',formato,'g') + '<br>' + messages.msgNoHigherThan.replace('[HIGHER]', maximum.string,'g'));
            }
            else
            {
                matchRegExpParam.push (messages.msgNoFormat.replace('[FORMAT]',formato,'g'));
            }            
            
            result = $.fn.validatebox.defaults.rules.matchRegExp.validator (value, matchRegExpParam);
            message = $.fn.validatebox.defaults.rules.matchRegExp.message;
            
            //-- Verificamos los mínimos y máximos (siempre que el formato haya sido verificado) --
            if (result)
            {
                var time = $.fn.validatebox.defaults.rules.isHour.toHourObject(value, separatorSymbol);
                
                if (!isEmpty(minimum.number) && isEmpty(maximum.number))
                {
                    message = messages.msgNoLowerThan.replace('[LOWER]', minimum.string,'g');                    
                    result = withSeconds ? minimum.number <= time.number : minimum.integer <= time.integer ;
                }
                else if (isEmpty(minimum.number) && !isEmpty(maximum.number))
                {
                    message = messages.msgNoHigherThan.replace('[HIGHER]', maximum.string,'g');
                    result = withSeconds ? maximum.number >= time.number : maximum.integer >= time.integer ;
                }
                else if (!isEmpty(minimum.number) && !isEmpty(maximum.number))
                {
                    message = messages.msgBetweenValues.replace('[LOWER]', minimum.string,'g').replace('[HIGHER]', maximum.string,'g');
                    result = withSeconds ? minimum.number <= time.number && time.number <= maximum.number : minimum.integer <= time.integer && time.integer <= maximum.integer;
                }
            }
            
            $.fn.validatebox.defaults.rules.isHour.message = !result ? message : "";
            return result; 
        },
        getSeparatorSymbol: function (param) {
            var symbol = ":"; //valor por defecto
            
            if (!isEmpty(param) && param.length >= 1 && !isEmpty(param[0]) && $.type(param[0]) === JSType.STRING)
            {
                symbol = trim(param[0]);
            }
            
            return symbol;
        },
        getWithSeconds: function (param) {
            var with_seconds = true; //valor por defecto
            
            if (!isEmpty(param) && param.length >= 2 && !isEmpty(param[1]) && $.type(param[1]) === JSType.BOOLEAN)
            {
                with_seconds = param[1];
            }
            
            return with_seconds;
        },
        getIs24Hours: function (param) {
            var is_24hours = false; //valor por defecto
            
            if (!isEmpty(param) && param.length >= 3 && !isEmpty(param[2]) && $.type(param[2]) === JSType.BOOLEAN)
            {
                is_24hours = param[2];
            }
            
            return is_24hours;
        },
        getMinimum: function (param) {
            var minimum = $.fn.validatebox.defaults.rules.isHour.defaultNullHourObject;
            
            if (!isEmpty(param) && param.length >= 4 && !isEmpty(param[3]) && $.type(param[3]) === JSType.STRING)
            {
                minimum = $.fn.validatebox.defaults.rules.isHour.toHourObject(trim(param[3]), $.fn.validatebox.defaults.rules.isHour.getSeparatorSymbol(param));
                
                if (!isEmpty(minimum.number))
                {
                    minimum = $.fn.validatebox.defaults.rules.isHour.validateLimit(minimum, param);
                }
            }
            
            return minimum;
        },
        getMaximum: function (param) {
            var maximum = $.fn.validatebox.defaults.rules.isHour.defaultNullHourObject;
            
            if (!isEmpty(param) && param.length >= 5 && !isEmpty(param[4]) && $.type(param[4]) === JSType.STRING)
            {
                maximum = $.fn.validatebox.defaults.rules.isHour.toHourObject(trim(param[4]), $.fn.validatebox.defaults.rules.isHour.getSeparatorSymbol(param));
                
                if (!isEmpty(maximum.number))
                {
                    maximum = $.fn.validatebox.defaults.rules.isHour.validateLimit(maximum, param);
                }
            }
            
            return maximum;
        },
        validateLimit: function (limit, param)
        {
            if (isEmpty(limit)) return $.fn.validatebox.defaults.rules.isHour.defaultNullHourObject;
            if (isEmptyObject(limit)) return $.fn.validatebox.defaults.rules.isHour.defaultNullHourObject;
            if (!limit.hasOwnProperty('number')) return $.fn.validatebox.defaults.rules.isHour.defaultNullHourObject;
            
            var show_seconds = $.fn.validatebox.defaults.rules.isHour.getWithSeconds(param);
            var is_24hours = $.fn.validatebox.defaults.rules.isHour.getIs24Hours(param);
            var new_hours = (is_24hours && limit.hours > 23) ? 23 : limit.hours;
            var new_minutes = limit.minutes > 59 ? 59 : limit.minutes;
            var new_seconds = limit.seconds;

            if (show_seconds == false)
            {
                new_seconds = null;
            }
            else if (isEmpty(new_seconds))
            {
                new_seconds = 0;
            }
            else if (new_seconds > 59)
            {
                new_seconds = 59;
            }

            return $.fn.validatebox.defaults.rules.isHour.newHourObject(new_hours, new_minutes, new_seconds);
        },
        standardMinimumHourObject: {hours: 0, minutes: 0, seconds: 0, string: '00:00:00', number: 0.0, integer: 0},
        standardMaximumHourObject: {hours: 23, minutes: 59, seconds: 59, string: '23:59:59', number: 2359.59, integer: 2359},
        defaultNullHourObject: { hours: null, minutes: null, seconds: null, string: '', number: null, integer: null},
        newHourObject: function (valueHours, valueMinutes, valueSeconds) {
            var valorString = '';
            var valorNumber = '';
            var valorInteger = '';
            
            if (!isEmpty(valueHours) && trim(valueHours).length > 0)
            {
                valueHours = (trim(valueHours).length == 1 ? "0" : "") + trim(valueHours);
                valorString = valorString + valueHours;
                valorNumber = valorNumber + valueHours;
                valorInteger = valorInteger + valueHours;
            }
            
            if (!isEmpty(valueMinutes) && trim(valueMinutes).length > 0)
            {
                valueMinutes = (trim(valueMinutes).length == 1 ? "0" : "") + trim(valueMinutes);
                valorString = valorString + ":";
                valorString = valorString + valueMinutes;
                valorNumber = valorNumber + valueMinutes;
                valorInteger = valorInteger + valueMinutes;
            }
            
            if (!isEmpty(valueSeconds) && trim(valueSeconds).length > 0)
            {
                valueSeconds = (trim(valueSeconds).length == 1 ? "0" : "") + trim(valueSeconds);
                valorString = valorString + ":";
                valorString = valorString + valueSeconds;
                valorNumber = valorNumber + "." + valueSeconds;
            }
    
            return {
                hours: valueHours,
                minutes: valueMinutes,
                seconds: valueSeconds,
                string: valorString,
                number: parseFloat(valorNumber),
                integer: parseInt(valorInteger)
            };
        },
        toHourObject: function (value, separator) {
            if (isEmpty(value)) return $.fn.validatebox.defaults.rules.isHour.defaultNullHourObject;
            if ($.type(value) !== JSType.STRING) return $.fn.validatebox.defaults.rules.isHour.defaultNullHourObject;
            if (trim(value).length == 0) return $.fn.validatebox.defaults.rules.isHour.defaultNullHourObject;
            
            if (trim(value) == "null") return $.fn.validatebox.defaults.rules.isHour.defaultNullHourObject;
            
            if (isEmpty(separator) || trim(separator).length == 0) separator = ":";
            
            var splits = trim(value).split(trim(separator));
            
            if (splits.length <= 1)
            {
                return $.fn.validatebox.defaults.rules.isHour.defaultNullHourObject; //No puede haber un solo elemento
            }
            else
            {
                var hours = trim(splits[0]);
                var minutes = trim(splits[1]);
                var seconds = null;
                if (splits.length >= 3)
                {
                    seconds = trim(splits[2]);
                }
                
                if (isEmpty(hours) || isEmpty(minutes) || (seconds !== null && isEmpty(seconds)))
                {
                    return $.fn.validatebox.defaults.rules.isHour.defaultNullHourObject;
                }
                
                if (!$.isNumeric(hours) || !$.isNumeric(minutes) || (seconds !== null && !$.isNumeric(seconds)))
                {
                    return $.fn.validatebox.defaults.rules.isHour.defaultNullHourObject;
                }
                
                hours = Math.abs(parseInt(hours));
                minutes = Math.abs(parseInt(minutes));
                if (seconds !== null)
                {
                    seconds = Math.abs(parseInt(seconds));
                }
                
                return $.fn.validatebox.defaults.rules.isHour.newHourObject(hours, minutes, seconds);
            }            
        },
        getErrorMessage: function (param) {
            var noFormat = "El valor ingresado no cumple con el fórmato válido definido para las horas ([FORMAT]).";
            var noLowerThan = "El valor ingresado no debe ser menor a [LOWER].";
            var noHigherThan = "El valor ingresado no debe ser mayor a [HIGHER].";
            var betweenValues = "El valor ingresado no debe ser menor a [LOWER] ni mayor a [HIGHER].";
            
            if (!isEmpty(param) && param.length >= 6 && !isEmpty(param[5]) && $.type(param[5]) === JSType.STRING && trim(param[5]).length > 0)
            {
                noFormat = trim(param[5]);
            }
            if (!isEmpty(param) && param.length >= 7 && !isEmpty(param[6]) && $.type(param[6]) === JSType.STRING && trim(param[6]).length > 0)
            {
                noLowerThan = trim(param[6]);
            }
            if (!isEmpty(param) && param.length >= 8 && !isEmpty(param[7]) && $.type(param[7]) === JSType.STRING && trim(param[7]).length > 0)
            {
                noHigherThan = trim(param[7]);
            }
            if (!isEmpty(param) && param.length >= 9 && !isEmpty(param[8]) && $.type(param[8]) === JSType.STRING && trim(param[8]).length > 0)
            {
                betweenValues = trim(param[8]);
            }
            
            return {
                msgNoFormat: noFormat,
                msgNoLowerThan: noLowerThan,
                msgNoHigherThan: noHigherThan,
                msgBetweenValues: betweenValues
            };
        },
        message: ''
    },
    matchRegExp : {
        validator: function (value, param){
            if (isEmpty(value)) return true;
            if (isEmpty(param))
            {
                $.fn.validatebox.defaults.rules.matchRegExp.message = "Expresión regular no reconocida o inexistente.";
                return false;
            }
            
            var patron = null;
            var msg_nomatch = "El valor ingresado no cumple con las reglas definidas por la expresión.";
            var msg_nopatron = "Expresión regular no reconocida o inexistente.";
            
            if (param.length >= 1 && !isEmpty(param[0]))
            {
                if ($.type(param[0]) === JSType.STRING)
                {
                    patron = trim(param[0]);
                }
                else
                {
                    patron = eval(param[0]);
                }                
            }
            if (param.length >= 2 && !isEmpty(param[1]))
            {
                msg_nomatch = trim(param[1]);
            }
            if (param.length >= 3 && !isEmpty(param[2]))
            {
                msg_nopatron = trim(param[2]);
            }
            
            if (isEmpty(patron))
            {
                $.fn.validatebox.defaults.rules.matchRegExp.message = msg_nopatron;
                return false;
            }
            
            var rg = new RegExp(patron);
            
            $.fn.validatebox.defaults.rules.matchRegExp.message = msg_nomatch;
            
            return rg.test(value);
        },
        message: ''
    },
    buscaEmailValidator: {  
        validator: function(value, param) {
            return param[0] <= 0;  
        },  
        message: 'Existe(n) {0} correo(s) inválido(s).'  
    },
    lengthRows: {
        validator: function(value, param) {
            var registros_requeridos = -1, registrados = 0;
            if(!isEmpty(param[0])) registros_requeridos = parseInt(param[0]);
            if(!isEmpty(param[1])) {
                var $datagrid = $(param[1]);
                if($datagrid.length > 0) {
                    registrados = $datagrid.datagrid('getRows').length;
                }
            }
            return (registros_requeridos === -1 || registrados >= registros_requeridos);
        },
        message: 'Se requiere que ingrese al menos {0} registro(s).'
    }
});
