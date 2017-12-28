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
	function priLetraMay($1,$2) { return $1.toUpperCase();};
	var expreg=/(^| )([\wáéíóúñ])/g;
	return cadena.replace(expreg, priLetraMay);
};
function priLetraMay(cadena){
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
function validaFechaDDMMAAAA(fecha){
		var dtCh= "/";
		var minYear=1900;
		var maxYear=2100;
		function isInteger(s){
			var i;
			for (i = 0; i < s.length; i++){
				var c = s.charAt(i);
				if (((c < "0") || (c > "9"))) return false;
			}
			return true;
		}
		function stripCharsInBag(s, bag){
			var i;
			var returnString = "";
			for (i = 0; i < s.length; i++){
				var c = s.charAt(i);
				if (bag.indexOf(c) == -1) returnString += c;
			}
			return returnString;
		}
		function daysInFebruary (year){
			return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
		}
		function DaysArray(n) {
			for (var i = 1; i <= n; i++) {
				this[i] = 31;
				if (i==4 || i==6 || i==9 || i==11) {this[i] = 30;}
				if (i==2) {this[i] = 29;}
			}
			return this;
		}
		function isDate(dtStr){
			var daysInMonth = DaysArray(12);
			var pos1=dtStr.indexOf(dtCh);
			var pos2=dtStr.indexOf(dtCh,pos1+1);
			var strDay=dtStr.substring(0,pos1);
			var strMonth=dtStr.substring(pos1+1,pos2);
			var strYear=dtStr.substring(pos2+1);
			strYr=strYear;
			if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1);
			if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1);
			for (var i = 1; i <= 3; i++) {
				if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1);
			}
			month=parseInt(strMonth);
			day=parseInt(strDay);
			year=parseInt(strYr);
			if (pos1==-1 || pos2==-1){
				return false;
			}
			if (strMonth.length<1 || month<1 || month>12){
				return false;
			}
			if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
				return false;
			}
			if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
				return false;
			}
			if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
				return false;
			}
			return true;
		}
		if(isDate(fecha)){
			return true;
		}else{
			return false;
		}
}
$(document).on('ready', function() {
	$('.vtCedula').keypress(function(e) {
		if (e.ctrlKey || e.altKey){return true;}
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
		if (e.ctrlKey || e.altKey){return true;}
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
		if (e.ctrlKey || e.altKey){return true;}
		return validar(String.fromCharCode(e.which), /^[a-zA-Z \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/);
	});
	$('.vtNombrelmayall').blur(function() {
		return $(this).val(priLetraMayAll(trim(cambio($(this).val(), /^[a-zA-Z \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/))));
	});
	$('.vtNombrelmay').keypress(function(e) {
		if (e.ctrlKey || e.altKey){return true;}
		return validar(String.fromCharCode(e.which), /^[a-zA-Z \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/);
	});
	$('.vtNombrelmay').blur(function() {
		return $(this).val(priLetraMay(trim(cambio($(this).val(), /^[a-zA-Z \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/))));
	});
	// $('.vtNumeroCaso').keypress(function(e) {
	// 	if (e.ctrlKey || e.altKey){return true;}
	// 	return validar(String.fromCharCode(e.which), /^[a-zA-Z0-9\x00\b]+$/);
	// });
	// $('.vtNumeroCaso').blur(function() {
	// 	return $(this).val((trim(cambio($(this).val(), /^[a-zA-Z0-9\x00\b]+$/))).toUpperCase());
	// });

	$('.vtNumeroCaso').keypress(function(e) {
		if (e.ctrlKey || e.altKey){return true;}
		return validar(String.fromCharCode(e.which), /^[0-9\=a-zA-Z\!\¡\¿\?\{\}\[\]\@\\\/\+\-\_\*\.\;\:\(\)\%\$\#\° \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/);
	});
	$('.vtNumeroCaso').blur(function() {
		return $(this).val((trim(cambio($(this).val(), /^[0-9\=a-zA-Z\!\¡\¿\?\{\}\[\]\@\\\/\+\-\_\*\.\;\:\(\)\%\$\#\° \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/))));
	});

	$('.vtObs').keypress(function(e) {
		if (e.ctrlKey || e.altKey){return true;}
		return validar(String.fromCharCode(e.which), /^[0-9\=a-zA-Z\!\¡\¿\?\{\}\[\]\@\\\/\+\-\_\*\.\;\:\(\)\%\$\#\° \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/);
	});
	$('.vtObs').blur(function() {
		return $(this).val(priLetraMay(trim(cambio($(this).val(), /^[0-9\=a-zA-Z\!\¡\¿\?\{\}\[\]\@\\\/\+\-\_\*\.\;\:\(\)\%\$\#\° \u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC\x00\b]+$/))));
	});
	$('.vtFecha').keypress(function(e) {
		if (e.ctrlKey || e.altKey){return true;}
		return validar(String.fromCharCode(e.which), /^[0-9\/\x00\b]+$/);
	});
	$('.vtFecha').blur(function() {
  		if (validaFechaDDMMAAAA($(this).val())){return true;};
  		return $(this).val("");
	});
	$('.vtFechahora12').keypress(function(e) {
		if (e.ctrlKey || e.altKey){return true;}
		return validar(String.fromCharCode(e.which), /^[aAPpMm 0-9\/\:\x00\b]+$/);
	});
	$('.vtFechahora12').blur(function() {
		return $(this).val(trim(cambio($(this).val(), /^[aAPpMm 0-9\/\:\x00\b]+$/)));
	});
	$('.vtDinero').keypress(function(e) {
		if (e.ctrlKey || e.altKey){return true;}
		return validar(String.fromCharCode(e.which), /^[0-9\,\.\x00\b]+$/);
	});
	$('.vtDinero').blur(function() {
		return $(this).val(trim(cambio($(this).val(), /^[0-9\,\.\x00\b]+$/)));
	});
});