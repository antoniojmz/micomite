//// Funciones
Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator) {
    var n = this;
    decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
    decSeparator = decSeparator == undefined ? "." : decSeparator,
    thouSeparator = thouSeparator == undefined ? "," : thouSeparator,
    sign = n < 0 ? "-" : "",
    i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
    j = (j = i.length) > 3 ? j % 3 : 0;
    return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
};
String.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator) {
    var n = this;
    decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
    decSeparator = decSeparator == undefined ? "." : decSeparator,
    thouSeparator = thouSeparator == undefined ? "," : thouSeparator,
    sign = n < 0 ? "-" : "",
    i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
    j = (j = i.length) > 3 ? j % 3 : 0;
    return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
};
String.prototype.count=function(s1) {
    return (this.length - this.replace(new RegExp(s1,"g"), '').length) / s1.length;
};
function trim(myString){
    return myString.replace(/([\ \t]+(?=[\ \t])|^\s+|\s+$)/g, '').replace(/^\s+/g,'');
}
function priLetraMayAll(cadena){
    cadena = cadena.toLowerCase();
    function priLetraMay($1,$2) { return $1.toUpperCase();};
    var expreg=/(^| )([\wáéíóúñ])/g;
    return cadena.replace(expreg, priLetraMay);
};
function priLetraMay(cadena){
    cadena = cadena.toLowerCase();
    return cadena.charAt(0).toUpperCase() + cadena.slice(1);
}
function validar(cadena, correcta){
    if (correcta.test(cadena)){
        return true;
    }else {
        return false;
    }
}
function cambio(cadena, correcta){
    var cadena_correcta = "";
    for (var i = 0; i< cadena.length; i++) {
        var caracter = cadena.charAt(i);
        if (validar(caracter, correcta)){cadena_correcta = cadena_correcta + caracter;}};
    return cadena_correcta;
}
$(function() {
    $('.vtCedula').keypress(function(e){
        if (e.ctrlKey || e.altKey || (e.which==13)){return true;}
        return validar(String.fromCharCode(e.which), /^[0-9\x00\b]+$/);
    });
    $('.vtCedula').blur(function() {
        $(this).val(parseInt($(this).val()));
        if ($(this).val() == 0) {
            $(this).val("");
        }
        return $(this).val(cambio($(this).val(), /^[0-9\x00\b]+$/));
    });
    $('.vtNro').keypress(function(e) {
        if (e.ctrlKey || e.altKey || (e.which==13)){return true;}
        return validar(String.fromCharCode(e.which), /^[0-9\x00\b]+$/);
    });
    $('.vtNro').blur(function() {
        // $(this).val(parseInt($(this).val()));
        if ($(this).val() == 0) {
            $(this).val("");
        }
        return $(this).val(cambio($(this).val(), /^[0-9\x00\b]+$/));
    });
    $('.vtNombrelmayall').keypress(function(e) {
        if (e.ctrlKey || e.altKey || (e.which==13)){return true;}
        return validar(String.fromCharCode(e.which), /^[a-zA-Z \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/);
    });
    $('.vtNombrelmayall').blur(function() {
        return $(this).val(priLetraMayAll(trim(cambio($(this).val(), /^[a-zA-Z \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/))));
    });
    $('.vtNombrelmay').keypress(function(e) {
        if (e.ctrlKey || e.altKey || (e.which==13)){return true;}
        return validar(String.fromCharCode(e.which), /^[a-zA-Z \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/);
    });
    $('.vtNombrelmay').blur(function() {
        return $(this).val(priLetraMay(trim(cambio($(this).val(), /^[a-zA-Z \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/))));
    });
    $('.vtNumeroCaso').keypress(function(e) {
        if (e.ctrlKey || e.altKey || (e.which==13)){return true;}
        return validar(String.fromCharCode(e.which), /^[a-zA-Z0-9\x00\b]+$/);
    });
    $('.vtNumeroCaso').blur(function() {
        return $(this).val((trim(cambio($(this).val(), /^[a-zA-Z0-9\x00\b]+$/))).toUpperCase());
    });
    $('.vtObs2').keypress(function(e) {
        if (e.ctrlKey || e.altKey || (e.which==13)){return true;}
        return validar(String.fromCharCode(e.which), /^[0-9\=a-zA-Z\!\¡\¿\?\{\}\[\]\@\\\/\+\-\_\*\.\;\:\(\)\%\$\#\° \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/);
    });
    $('.vtObs2').blur(function() {
        return $(this).val((trim(cambio($(this).val(), /^[0-9\=a-zA-Z\!\¡\¿\?\{\}\[\]\@\\\/\+\-\_\*\.\;\:\(\)\%\$\#\° \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/))).toUpperCase());
    });
    $('.vtObs').keypress(function(e) {
        if (e.ctrlKey || e.altKey || (e.which==13)){return true;}
        return validar(String.fromCharCode(e.which), /^[0-9\=a-zA-Z\!\¡\¿\?\{\}\[\]\@\\\/\+\-\_\*\.\;\:\(\)\%\$\#\° \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/);
    });
    $('.vtObs').blur(function() {
        return $(this).val(priLetraMay(trim(cambio($(this).val(), /^[0-9\=a-zA-Z\!\¡\¿\?\{\}\[\]\@\\\/\+\-\_\*\.\;\:\(\)\%\$\#\° \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/))));
    });
    $('.vtPass').keypress(function(e) {
        if (e.ctrlKey || e.altKey || (e.which==13)){return true;}
        return validar(String.fromCharCode(e.which), /^[0-9\=a-zA-Z\!\¡\¿\?\{\}\[\]\@\\\/\+\-\_\*\.\;\:\(\)\%\$\#\° \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/);
    });
    $('.vtPass').blur(function() {
        return $(this).val(trim(cambio($(this).val(), /^[0-9\=a-zA-Z\!\¡\¿\?\{\}\[\]\@\\\/\+\-\_\*\.\;\:\(\)\%\$\#\° \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/)));
    });
    $('.vtusuario').keypress(function(e) {
        if (e.ctrlKey || e.altKey || (e.which==13)){return true;}
        return validar(String.fromCharCode(e.which), /^[a-zA-Z0-9\x00\b]+$/);
    });
    $('.vtusuario').blur(function() {
        return $(this).val((trim(cambio($(this).val(), /^[a-zA-Z0-9\x00\b]+$/))).toLowerCase());
    });
});