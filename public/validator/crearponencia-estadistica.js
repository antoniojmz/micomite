var miTabla;
var FI= ""; FF= "";
var FIg= ""; FFg= "";
var vtitulo = "";

$(document).ajaxStart(function () {
	$.blockUI({
		blockMsgClass: 'blockui',
		message: '<img src="' + ruta + "/recursos/js/select2-spinner.gif" + '" /> Procesando...',
		css: {'border-radius': '5px', 'width': '190px', 'padding': '4px'}
	});
});
$( document ).ajaxStop(function() {
	$.unblockUI();
});

function exportar(el, nombfile, libro){
	var valor1 = $("#example_length label select option:selected").text();
	var valor2 = "-1";
	$("#exp2").attr('download', nombfile);
	$("#example_length label select option[value='"+valor2+"']").prop('selected', true).change();
    $("#example > thead").append(vtitulo);
	ExcellentExport.excel(el, 'example', libro);
	$("#example_length label select option[value='"+valor1+"']").prop('selected', true).change();
};
(function ($) {
    "use strict";
    $.extend($.fn.select2.defaults, {
        formatNoMatches: function () { return "No se encontraron resultados"; },
        formatInputTooShort: function (input, min) { var n = min - input.length; return "Por favor, introduzca " + n + " car" + (n == 1? "&aacute" : "a") + "cter" + (n == 1? "" : "es"); },
        formatInputTooLong: function (input, max) { var n = input.length - max; return "Por favor, elimine " + n + " car" + (n == 1? "&aacute" : "a") + "cter" + (n == 1? "" : "es"); },
        formatSelectionTooBig: function (limit) { return "S&oacutelo puede seleccionar " + limit + " elemento" + (limit == 1 ? "" : "s"); },
        formatLoadMore: function (pageNumber) { return "Cargando m&aacutes resultados..."; },
        formatSearching: function () { return "Buscando..."; }
    });
})(jQuery);
function actcheck(vcheck, vdiv, vselect){
	$(vcheck).on('change', function () {
		$(vselect).select2('data', null);
		if ($(this).is(':checked')){$(vdiv).unblock();}
		else{$(vdiv).block({ message: null });}
	});
};
function format(item) {return item.text;};
//Limpiar combos
function cleanCombo(combo){
	$(combo).select2('data', null);
	$(combo).select2({
        placeholder: "Seleccione...",
        allowClear: true,
        data:[]
    });
};
function llenaResponsabilidad(varRuta){
	$.post(ruta+'/ponencia/crear/'+ varRuta, function(opts){
		var regtrue = "Seleccione...";
		if(opts.total == 0){
			regtrue = "Esta motivo no posee responsabilidad";
			$("#ckr").attr('checked',false);
			$("#responsabilidad").select2('data', null);
			$("#divr").block({ message: null });
		};
		$("#responsabilidad").select2({
			placeholder: regtrue,
			allowClear: true,
			data:{ results: opts.registros, id:'id', text: 'text' },
			formatSelection: format,
			formatResult: format
		});
	});
};
function caso0(){
	//deshabilitar todo
	$('#divFechaspan').block({ message: null });
	$('#divasunto').block({ message: null });
	$('#div1ta').block({ message: null });
	$('#divta').block({ message: null });
	$('#div1d').block({ message: null });
	$('#divd').block({ message: null });
	$('#div1t').block({ message: null });
	$('#divt').block({ message: null });
	$('#div1me').block({ message: null });
	$('#divme').block({ message: null });
	$('#div1r').block({ message: null });
	$('#divr').block({ message: null });
	//limpiar combo
	$("#ta").select2('data', null);
	$("#tdependencia").select2('data', null);
	$("#tribunal").select2('data', null);
	$("#motivoestado").select2('data', null);
	$("#responsabilidad").select2('data', null);
	//desmarcar
	$(".ck").removeAttr("checked");
	$("#grafico").show();
	$("#asunto").val("");
};
function caso1(){
	$('#divFechaspan').unblock();
	$('#div1ta').unblock();
	$('#div1d').unblock();
	$('#divt').unblock();
	$('#div1me').unblock();
	$('#div1r').unblock();
};
function creartabla(varruta, vcolumas, nroreporte){
	$("#example > thead").append(vtitulo);
//	alert("Ruta: " + varruta);
	if (nroreporte == 1 || nroreporte == 2 || nroreporte == 4 || nroreporte == 7 || nroreporte == 3 || nroreporte == 8 || nroreporte == 10 || nroreporte == 11 || nroreporte == 14 || nroreporte == 16 || nroreporte == 15 || nroreporte == 17 || nroreporte == 18 || nroreporte == 19){
		miTabla = $('#example').dataTable( {
			"oLanguage": {
				"sUrl": ruta + "/recursos/txt-esp/de_DE-all.txt"
			},
			"aLengthMenu": [[3, 5, 10, 15, -1], [3, 5, 10, 15, "Todo"]],
			"sServerMethod": "POST",
			"bRetrieve": true,
			"sAjaxSource": varruta,
			"bDestroy": true,
			"sAjaxDataProp": "data",
			"bDeferRender": true,
			"bAutoWidth": true,
			"sPaginationType" : "full_numbers",
			"aoColumns": vcolumas,
			"sScrollY": "200px",
			"sScrollX": "100%"
		});
	}else{
		if (nroreporte == 12){
			miTabla = $('#example').dataTable( {
				"oLanguage": {
					"sUrl": ruta + "/recursos/txt-esp/de_DE-all.txt"
				},
				"aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todo"]],
				"sServerMethod": "POST",
				"bRetrieve": true,
				"sAjaxSource": varruta,
				"bDestroy": true,
				"sAjaxDataProp": "data",
				"bDeferRender": true,
				"bAutoWidth": true,
				"sPaginationType" : "full_numbers",
				"aoColumns": vcolumas,
				"sScrollX": "100%",
				"sScrollXInner": "110%",
				"bScrollCollapse": true,
				"sScrollY": "200",
				"sScrollX": "100%",
				"sScrollXInner": "650%"
			});
		}else{
			miTabla = $('#example').dataTable( {
				"oLanguage": {
					"sUrl": ruta + "/recursos/txt-esp/de_DE-all.txt"
				},
				"aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todo"]],
				"sServerMethod": "POST",
				"bRetrieve": true,
				"sAjaxSource": varruta,
				"bDestroy": true,
				"sAjaxDataProp": "data",
				"bDeferRender": true,
				"bAutoWidth": true,
				"sPaginationType" : "full_numbers",
				"aoColumns": vcolumas,
				"sScrollX": "100%",
				"sScrollXInner": "110%",
				"bScrollCollapse": true,
				"sScrollY": "200",
				"sScrollX": "100%",
				"sScrollXInner": "200%"
			});
		};
	};
};

function fechadinamic(d){
	$('#date-range9').dateRangePicker({
		format: 'DD-MM-YYYY',
		separator : ' al ',
		language: 'custom',
		startDate: '01-01-2010',
		endDate: '01-01-2020',
		minDays: 1,
		maxDays: d,
		getValue: function()
		{
			return this.innerHTML;
		},
		setValue: function(s)
		{
			this.innerHTML = s;
		},
		shortcuts : null,
		customShortcuts:
		[{
				name: 'Mes ant.',
				dates : function()
				{
					var start = moment().subtract('months', 1).startOf('month').toDate();
					var end = moment().subtract('months', 1).endOf('month').toDate();
					return [start,end];
				}
			},{
				name: 'Lo que va de mes.',
				dates : function()
				{
					var start = moment().startOf('month').toDate();
					var end = moment().toDate();
					return [start,end];
				}
			},{
				name: 'Mes act.',
				dates : function()
				{
					var start = moment().startOf('month').toDate();
					var end = moment().endOf('month').toDate();
					return [start,end];
				}
			}
		]
	}).bind('datepicker-apply',function(event,obj){
		console.log(obj);
	});
};

function fechalimit(d, f_limit){
	$('#date-range9').dateRangePicker({
		format: 'DD-MM-YYYY',
		separator : ' al ',
		language: 'custom',
		startDate: '01-01-2010',
		endDate: f_limit,
		minDays: 1,
		maxDays: d,
		getValue: function()
		{
			return this.innerHTML;
		},
		setValue: function(s)
		{
			this.innerHTML = s;
		},
		shortcuts : null,
		customShortcuts:
		[{
				name: 'Mes ant.',
				dates : function()
				{
					var start = moment().subtract('months', 1).startOf('month').toDate();
					var end = moment().subtract('months', 1).endOf('month').toDate();
					return [start,end];
				}
			},{
				name: 'Lo que va de mes.',
				dates : function()
				{
					var start = moment().startOf('month').toDate();
					var end = moment().toDate();
					return [start,end];
				}
			},{
				name: 'Mes act.',
				dates : function()
				{
					var start = moment().startOf('month').toDate();
					var end = moment().endOf('month').toDate();
					return [start,end];
				}
			}
		]
	}).bind('datepicker-apply',function(event,obj){
		console.log(obj);
	});
};

function procesar(){
		$("#datos").show();
		var varrutalista = "";
		var vcolumnas = "";
		var fc = "";
		var fecha = $('#date-range9').text();
		var params = ""; str = "";
		var arr = fecha.split(' al ');

		FI = arr[0]; FF = arr[1];
		arr = FI.split("-");
		FI = arr[2] + "-" + arr[1] + "-" + arr[0];
		FIg= arr[0] + "-" + arr[1] + "-" + arr[2];//este es el que le da el formato a la fecha
		arr = FF.split("-");
		FF = arr[2] + "-" + arr[1] + "-" + arr[0];
		FFg= arr[0] + "-" + arr[1] + "-" + arr[2]; //este es el que le da el formato a la fecha

		var nrocaso = parseInt($("#reporte").select2("val"));
		var data = $("#reporte").select2("data");delete data.element;
		fc = $("#fecha_act").val();
		fc = fc.substring(0, 10);

		$("#tipoReporte").text("Reporte: " + JSON.parse(JSON.stringify(data.text)));// este es el que trae los nombres de los reporte
		$("#tipoReporteFC").text(" Desde " + FIg + ' Hasta ' + FFg );// este es el que trae la fecha del reporte

		switch (true) {
    	    case (nrocaso == 1):
    	    //	"Tribunales"
    	    	params = {organo: $("#tdependencia").select2("val"), ponencia: $("#tribunal").select2("val")};
            	str = $.param(params);
    	    	varrutalista = ruta + "/ponencia/crear/listaDetalleTribunales?" + str;
    	    	vtitulo = "<tr><th>Descripci&oacuten</th><th>C&oacutedigo</th><th>Dependencia</th><th>Tribunal</th></tr>";
    	    	vcolumnas = [{"mData":"descripcion"},{"mData":"ponencia"},{"mData":"des_corta"},{"mData":"tribunal"}];
    	    	$("#grafico").hide();
    	    	break;
    	    case (nrocaso == 2):
    	    	params = {tipoaud: $("#tdependencia").select2("val")};
	        	str = $.param(params);
		    	varrutalista = ruta + "/ponencia/crear/listaTipoAudiencia?" + str;
		    	vtitulo = "<tr><th>Descripci&oacuten</th><th>C&oacutedigo</th><th>Ley</th></tr>";
		    	vcolumnas = [{"mData":"text"},{"mData":"id"},{"mData":"des1"}];
		    	$("#grafico").hide();
    	    	break;
    	    case (nrocaso == 3):
    	    	params = {motivoestado: $("#motivoestado").select2("val")};
    	    	str = $.param(params);
		    	varrutalista = ruta + "/ponencia/crear/listaTipoResultadoMotivoEstado?" + str;
		    	vtitulo = "<tr><th>Descripci&oacuten</th><th>C&oacutedigo</th></tr>";
		    	vcolumnas = [{"mData":"text"},{"mData":"id"}];
		    	$("#grafico").hide();
		    	break;
    	    case (nrocaso == 5):
    	    	// Detalle agenda
	    	    params = {fi: FI, ff: FF, tipoAud: $("#ta").select2("val"), dependencia: $("#tdependencia").select2("val"), tribunal: $("#tribunal").select2("val"), motivoestado: $("#motivoestado").select2("val"), responsabilidad: $("#responsabilidad").select2("val")};
	        	str = $.param(params);
	        	varrutalista = ruta + "/ponencia/crear/listaAgendaAud?" + str;
	        	if ($("#responsabilidad").select2("val")==""){
			    	vtitulo = "<tr><th>Asunto</th><th>Tipo de audiencia</th><th>Fecha</th><th>Dependencia</th><th>Tribunal</th><th>Turno</th><th>Horario</th><th>Condición</th><th>Fiscalia</th><th>Defensor</th><th>Usuario</th><th>Nombre-Apellido</th></tr>";
			    	vcolumnas = [{"mData":"asunto"},{"mData":"descripcion"},{"mData":"apunte_fecha"},{"mData":"des_corta"},{"mData":"tribunal"},{"mData":"turno"},{"mData":"horario"},{"mData":"des_apunte_estado"},{"mData":"fiscal"},{"mData":"defensor"},{"mData":"usuario"},{"mData":"des_usuario"}];
	        	}else{
	        		vtitulo = "<tr><th>Asunto</th><th>Tipo de audiencia</th><th>Fecha</th><th>Dependencia</th><th>Tribunal</th><th>Turno</th><th>Horario</th><th>Condición</th><th>Responsabilidad</th></tr>";
			    	vcolumnas = [{"mData":"asunto"},{"mData":"descripcion"},{"mData":"apunte_fecha"},{"mData":"des_corta"},{"mData":"tribunal"},{"mData":"turno"},{"mData":"horario"},{"mData":"des_apunte_estado"},{"mData":"des_tipo_responsabilidad"}];
	        	};
	        	$("#grafico").hide();
    	    	break;
    	    case (nrocaso == 18):
    	    	// Detalle agenda diferida
	    	    params = {fi: FI, ff: FF, tipoAud: $("#ta").select2("val"), dependencia: $("#tdependencia").select2("val"), tribunal: $("#tribunal").select2("val"), motivoestado: $("#motivoestado").select2("val"), responsabilidad: $("#responsabilidad").select2("val")};
	        	str = $.param(params);
	        	varrutalista = ruta + "/ponencia/crear/listaagendaDif?" + str;
	        	if ($("#responsabilidad").select2("val")==""){
			    	vtitulo = "<tr><th>Asunto</th><th>Tipo de audiencia</th><th>Fecha</th><th>Dependencia</th><th>Tribunal</th><th>Turno</th><th>Horario</th><th>Condición</th><th>Fiscalia</th><th>Defensor</th><th>Nomenclatura Resp.</th><th>Responsabilidad</th><th>Nomenclatura Motivo</th><th>Motivos</th><th>Usuario</th><th>Nombre-Apellido</th></tr>";
			    	vcolumnas = [{"mData":"asunto"},{"mData":"descripcion"},{"mData":"apunte_fecha"},{"mData":"des_corta"},{"mData":"tribunal"},{"mData":"turno"},{"mData":"horario"},{"mData":"des_apunte_estado"},{"mData":"fiscal"},{"mData":"defensor"},{"mData":"des_responsabilidad"},{"mData":"des_tipo_responsabilidad"},{"mData":"des_motivo "},{"mData":"des_motivo_estado"},{"mData":"usuario"},{"mData":"des_usuario"}];
	        	}else{
	        		vtitulo = "<tr><th>Asunto</th><th>Tipo de audiencia</th><th>Fecha</th><th>Dependencia</th><th>Tribunal</th><th>Turno</th><th>Horario</th><th>Condición</th><th>Responsabilidad</th></tr>";
			    	vcolumnas = [{"mData":"asunto"},{"mData":"descripcion"},{"mData":"apunte_fecha"},{"mData":"des_corta"},{"mData":"tribunal"},{"mData":"turno"},{"mData":"horario"},{"mData":"des_apunte_estado"},{"mData":"des_tipo_responsabilidad"}];
	        	};
	        	$("#grafico").hide();
    	    	break;
    	    case (nrocaso == 6):
    	    	//Histórico por asunto agenda
	    	    params = {asunto: $("#asunto").val()};
	        	str = $.param(params);
	        	varrutalista = ruta + "/ponencia/crear/histoAgenda?" + str;
		    	vtitulo = "<tr><th>Asunto</th><th>Tipo de audiencia</th><th>Fecha</th><th>Dependencia</th><th>Tribunal</th><th>Turno</th><th>Horario</th><th>Condición</th></tr>";
		    	vcolumnas = [{"mData":"asunto"},{"mData":"descripcion"},{"mData":"apunte_fecha"},{"mData":"des_corta"},{"mData":"tribunal"},{"mData":"turno"},{"mData":"horario"},{"mData":"des_apunte_estado"}];
	        	$("#grafico").hide();
    	    	break;
    	    case (nrocaso == 13):
    	    	//Histórico por asunto agenda resultado
	    	    params = {asunto: $("#asunto").val()};
	        	str = $.param(params);
	        	varrutalista = ruta + "/ponencia/crear/histoAgendaResultado?" + str;
		    	vtitulo = "<tr><th>Asunto</th><th>Tipo de audiencia</th><th>Fecha</th><th>Dependencia</th><th>Tribunal</th><th>Turno</th><th>Horario</th><th>Condición</th><th>Responsabilidad</th></tr>";
		    	vcolumnas = [{"mData":"asunto"},{"mData":"descripcion"},{"mData":"apunte_fecha"},{"mData":"des_corta"},{"mData":"tribunal"},{"mData":"turno"},{"mData":"horario"},{"mData":"des_apunte_estado"},{"mData":"des_tipo_responsabilidad"}];
	        	$("#grafico").hide();
    	    	break;
    	    case (nrocaso == 9):
    	    	//Detalle agenda sin resultado
    	    	params = {fi: FI, ff: FF, tipoAud: $("#ta").select2("val"), dependencia: $("#tdependencia").select2("val"), tribunal: $("#tribunal").select2("val"), motivoestado: $("#motivoestado").select2("val")};
	        	str = $.param(params);
	        	varrutalista = ruta + "/ponencia/crear/listaAudSinResultado?" + str;
        		vtitulo = "<tr><th>Asunto</th><th>Tipo de audiencia</th><th>Fecha</th><th>Dependencia</th><th>Tribunal</th><th>Turno</th><th>Horario</th><th>Tiempo</th><th>Fiscalia</th><th>Defensor</th><th>Usuario</th><th>Nombre-Apellido</th></tr>";
		    	vcolumnas = [{"mData":"asunto"},{"mData":"descripcion"},{"mData":"apunte_fecha"},{"mData":"des_corta"},{"mData":"tribunal"},{"mData":"turno"},{"mData":"horario"},{"mData":"des_tipo_responsabilidad"},{"mData":"fiscal"},{"mData":"defensor"},{"mData":"usuario"},{"mData":"des_usuario"}];
		    	$("#grafico").hide();
		    	break;
    	    case (nrocaso == 4):
    	    	// Total de audiencias con y sin resultado
    	    	params = {fa: fc,fi: FI, ff: FF, tipoAud: ($("#ckta").is(':checked') ? 1 : 0) + $("#ta").select2("val"), dependencia: ($("#ckd").is(':checked') ? 1 : 0) + $("#tdependencia").select2("val"), tribunal: ($("#ckt").is(':checked') ? 1 : 0) + $("#tribunal").select2("val"), motivoestado: ($("#ckme").is(':checked') ? 1 : 0) + $("#motivoestado").select2("val")};
	        	str = $.param(params);
	        	varrutalista = ruta + "/ponencia/crear/listaSResultadototal?" + str;
	    		vtitulo = "<tr><th>Descripci&oacuten</th><th>Audiencias</th><th>Audiencia con resultado</th><th>Audiencias sin resultado</th><th>Audiencias por celebrar</th></tr>";
		    	vcolumnas = [{"mData":"des_corta"},{"mData":"desTotal1"},{"mData":"desTotal3"},{"mData":"desTotal2"},{"mData":"desTotal4"}];
		    	break;
    	    case (nrocaso == 7):
    	    	 // Estadísticas de audiencias
    	    	params = {fi: FI, ff: FF, tipoAud: ($("#ckta").is(':checked') ? 1 : 0) + $("#ta").select2("val"), dependencia: ($("#ckd").is(':checked') ? 1 : 0) + $("#tdependencia").select2("val"), tribunal: ($("#ckt").is(':checked') ? 1 : 0) + $("#tribunal").select2("val"), motivoestado: ($("#ckme").is(':checked') ? 1 : 0) + $("#motivoestado").select2("val"), itinerantes: ($("#cki").is(':checked') ? 1 : 0)};
	        	str = $.param(params);
	        	varrutalista = ruta + "/ponencia/crear/listaEstadisticaAudiencia?" + str;
	    		vtitulo = "<tr><th>Descripci&oacuten</th><th>Total</th></tr>";
		    	vcolumnas = [{"mData":"des_corta"},{"mData":"desTotal1"}];
		    	break;
    	    case (nrocaso == 8):
    	    	//Estadísticas de resultado
    	    	params = {fi: FI, ff: FF, tipoAud: ($("#ckta").is(':checked') ? 1 : 0) + $("#ta").select2("val"), dependencia: ($("#ckd").is(':checked') ? 1 : 0) + $("#tdependencia").select2("val"), tribunal: ($("#ckt").is(':checked') ? 1 : 0) + $("#tribunal").select2("val"), motivoestado: ($("#ckme").is(':checked') ? 1 : 0) + $("#motivoestado").select2("val"), responsabilidad: ($("#ckr").is(':checked') ? 1 : 0) + $("#responsabilidad").select2("val"), itinerantes: ($("#cki").is(':checked') ? 1 : 0)};
	        	str = $.param(params);
	        	varrutalista = ruta + "/ponencia/crear/listaEstadisticaAudienciaResultado?" + str;
	        	vtitulo = "<tr><th>Descripci&oacuten</th><th>Total</th></tr>";
		    	vcolumnas = [{"mData":"des_corta"},{"mData":"desTotal1"}];
		    	break;
    	    case (nrocaso == 10):
    	    	params = {responsabilidad: $("#responsabilidad").select2("val")};
	        	str = $.param(params);
		    	varrutalista = ruta + "/ponencia/crear/listaTipoRAudienciaR?" + str;
		    	vtitulo = "<tr><th>Apunte estado</th><th>Tipo de responsabilidad</th><th>Motivo estado</th><th>Alias</th></tr>";
		    	vcolumnas = [{"mData":"text"},{"mData":"des1"},{"mData":"id"},{"mData":"des2"}];
		    	$("#grafico").hide();break;
    	    case (nrocaso == 11):
    	    	//Total Audiencia con Resultado Condición"
    	    	params = {fi: FI, ff: FF, tipoAud: ($("#ckta").is(':checked') ? 1 : 0) + $("#ta").select2("val"), dependencia: ($("#ckd").is(':checked') ? 1 : 0) + $("#tdependencia").select2("val"), tribunal: ($("#ckt").is(':checked') ? 1 : 0) + $("#tribunal").select2("val"), motivoestado: ($("#ckme").is(':checked') ? 1 : 0) + $("#motivoestado").select2("val"), responsabilidad: ($("#ckr").is(':checked') ? 1 : 0) + $("#responsabilidad").select2("val")};
	        	str = $.param(params);
	        	varrutalista = ruta + "/ponencia/crear/totalAudResultadoMotivoEstado?" + str;
//	        	vtitulo = "<tr><th>Descripci&oacuten</th><th>Total</th><th>F</th><th>D.Componente</th><th>Nulidad</th><th>Inh. Juez(a)</th><th>P.Orden Apren.</th><th>P.S.Cond.Proc.</th><th>Terminado</th><th>Diferido</th><th>Continuada</th></tr>";
	        	vtitulo = "<tr><th>Descripci&oacuten</th><th>Total</th><th>Diferida</th><th>D. Competencia</th><th>Inh. Rec. Juez(a)</th><th>Nulidad</th><th>P.Orden Apren.</th><th>Continuada</th><th>P.S.Cond.Proc.</th><th>Terminada</th><th>Fijada</th></tr>";
	        	vcolumnas = [{"mData":"des_corta"},{"mData":"desTotal1"},{"mData":"desTotal2"},{"mData":"desTotal3"},{"mData":"desTotal4"},{"mData":"desTotal5"},{"mData":"desTotal6"},{"mData":"desTotal7"},{"mData":"desTotal8"},{"mData":"desTotal9"},{"mData":"desTotal10"}];
		    	break;
    	    case (nrocaso == 12):
    	    	//"Total audiencia con resultado responsabilidad"
    	    	params = {fi: FI, ff: FF, tipoAud: ($("#ckta").is(':checked') ? 1 : 0) + $("#ta").select2("val"), dependencia: ($("#ckd").is(':checked') ? 1 : 0) + $("#tdependencia").select2("val"), tribunal: ($("#ckt").is(':checked') ? 1 : 0) + $("#tribunal").select2("val"), motivoestado: ($("#ckme").is(':checked') ? 1 : 0) + $("#motivoestado").select2("val"), responsabilidad: ($("#ckr").is(':checked') ? 1 : 0) + $("#responsabilidad").select2("val")};
        		str = $.param(params);
        		varrutalista = ruta + "/ponencia/crear/totalAudResultadoR?" + str;
        		vtitulo = "<tr><th>Descripci&oacuten</th><th>Total</th><th>ISP-FEJCAD</th><th>ISP-FEJC10</th><th>IMPLIB-IMC</th><th>IAPJAP-IMC</th><th>ITRIB-INT</th><th>IDP-IMC</th><th>IDPRIV-IMC</th><th>IMP-IMC</th><th>ALGZGO-INC</th><th>IJUEZ-INC</th><th>ISECRT-INC</th><th>ITRIB-PAP</th><th>ITRIB-SND</th><th>APJAPR-SOL</th><th>IDPRIV-SOL</th><th>IDP-SOL</th><th>IMP-SOL</th><th>IPOLIC-FLT</th><th>IMPLIB-SOL</th><th>IAPJAP-SOL</th></tr>";
        		vcolumnas = [{"mData":"des_corta"},{"mData":"desTotal1"},{"mData":"desTotal2"},{"mData":"desTotal3"},{"mData":"desTotal4"},{"mData":"desTotal5"},{"mData":"desTotal6"},{"mData":"desTotal7"},{"mData":"desTotal8"},{"mData":"desTotal9"},{"mData":"desTotal10"}, {"mData":"desTotal11"}, {"mData":"desTotal12"}, {"mData":"desTotal13"}, {"mData":"desTotal14"}, {"mData":"desTotal15"}, {"mData":"desTotal16"}, {"mData":"desTotal17"}, {"mData":"desTotal18"}, {"mData":"desTotal19"}, {"mData":"desTotal20"}, {"mData":"desTotal21"}];
        		$("#grafico").hide();break;
    	    case (nrocaso == 14):
    	    	// total audiencia responsabilidad general
    	    	params = {fi: FI, ff: FF, tipoAud: ($("#ckta").is(':checked') ? 1 : 0) + $("#ta").select2("val"), dependencia: ($("#ckd").is(':checked') ? 1 : 0) + $("#tdependencia").select2("val"), tribunal: ($("#ckt").is(':checked') ? 1 : 0) + $("#tribunal").select2("val"), motivoestado: ($("#ckme").is(':checked') ? 1 : 0) + $("#motivoestado").select2("val"), responsabilidad: ($("#ckr").is(':checked') ? 1 : 0) + $("#responsabilidad").select2("val")};
    	    	str = $.param(params);
    	    	varrutalista = ruta + "/ponencia/crear/listaresultadoresponsabilidad?" + str;
    	    	vtitulo = "<tr><th>Descripci&oacuten</th><th>Total</th></tr>";
    	    	vcolumnas = [{"mData":"des_corta"},{"mData":"desTotal1"}];
    	    	break;
    	    case (nrocaso == 15):
    	    	//"Total audiencia con Condicion especificas"
    	    	params = {fi: FI, ff: FF, tipoAud: ($("#ckta").is(':checked') ? 1 : 0) + $("#ta").select2("val"), dependencia: ($("#ckd").is(':checked') ? 1 : 0) + $("#tdependencia").select2("val"), tribunal: ($("#ckt").is(':checked') ? 1 : 0) + $("#tribunal").select2("val"), motivoestado: ($("#ckme").is(':checked') ? 1 : 0) + $("#motivoestado").select2("val"), responsabilidad: ($("#ckr").is(':checked') ? 1 : 0) + $("#responsabilidad").select2("val")};
        		str = $.param(params);
        		varrutalista = ruta + "/ponencia/crear/listaCondicionesEspecificas?" + str;
        		vtitulo = "<tr><th>Descripci&oacuten</th><th>Total</th></tr>";
    	    	vcolumnas = [{"mData":"des_corta"},{"mData":"desTotal1"}];
        		break;
    	    case (nrocaso == 16):
    	    	//"Total audiencia con resultado responsabilidad"
    	    	params = {fi: FI, ff: FF, tipoAud: ($("#ckta").is(':checked') ? 1 : 0) + $("#ta").select2("val"), dependencia: ($("#ckd").is(':checked') ? 1 : 0) + $("#tdependencia").select2("val"), tribunal: ($("#ckt").is(':checked') ? 1 : 0) + $("#tribunal").select2("val"), motivoestado: ($("#ckme").is(':checked') ? 1 : 0) + $("#motivoestado").select2("val"), responsabilidad: ($("#ckr").is(':checked') ? 1 : 0) + $("#responsabilidad").select2("val")};
    	    	str = $.param(params);
    	    	varrutalista = ruta + "/ponencia/crear/listaresponpoderjudicial?" + str;
    	    	vtitulo = "<tr><th>Descripci&oacuten</th><th>Total</th></tr>";
    	    	vcolumnas = [{"mData":"des_corta"},{"mData":"desTotal1"}];
    	    	break;
    	    case (nrocaso == 17):
    	    	//total audiencia responsabilidad
    	    	params = {fi: FI, ff: FF, tipoAud: ($("#ckta").is(':checked') ? 1 : 0) + $("#ta").select2("val"), dependencia: ($("#ckd").is(':checked') ? 1 : 0) + $("#tdependencia").select2("val"), tribunal: ($("#ckt").is(':checked') ? 1 : 0) + $("#tribunal").select2("val"), motivoestado: ($("#ckme").is(':checked') ? 1 : 0) + $("#motivoestado").select2("val"), responsabilidad: ($("#ckr").is(':checked') ? 1 : 0) + $("#responsabilidad").select2("val")};
    	    	str = $.param(params);
    	    	varrutalista = ruta + "/ponencia/crear/listaresultadoresponsabilidadES?" + str;
    	    	vtitulo = "<tr><th>Descripci&oacuten</th><th>Total</th></tr>";
    	    	vcolumnas = [{"mData":"des_corta"},{"mData":"desTotal1"}];
    	    	break;
    	    case (nrocaso == 19):
    	    	//total audiencia responsabilidad
    	    	varrutalista = ruta + "/ponencia/crear/listaDetalleRespMot?" ;
    	    	vtitulo = "<tr><th>Descripci&oacuten</th></tr>";
    	    	vcolumnas = [{"mData":"descripcion"}];
    	    	$("#grafico").hide();
    	    	break;
		};
		creartabla(varrutalista, vcolumnas, nrocaso);
		$("#criterios").hide();
};

//*******************************************************************************************
// Validar
$.validator.addMethod("valcomboreq", function(value, element) {
	var v_id = $($(element).parent()).attr("id");
    if (value == ""){
   		valcomboreqmostrar(v_id);
    	return false;
    }else{
    	valcomboreqocultar(v_id);
    	return true;
    };
}, null);

function valcomboreqmostrar(element){
	$("#" + element + " div a.select2-choice").attr("title", "").addClass("arrow_box").css("border","0.5px solid rgba(230, 88, 83, 0.9)");
    $("#" + element + " div a.select2-choice").tooltip(
      { content: "Se requiere este campo" },
      { tooltipClass:"arrow_box"},
      { position: { my: "left top+8", at: "left bottom", collision: "flipfit"}}
    );
};

function valcomboreqocultar(element){
	$("#" + element + " div a.select2-choice").removeAttr("title").removeClass("arrow_box").css("border","");
    $("#" + element + " div a.select2-choice").tooltip();
    $("#" + element + " div a.select2-choice").tooltip("destroy");
};

function mostrar(element){
    $(element).tooltip(
            {tooltipClass:"arrow_box"},
            {position: { my: "left top+8", at: "left bottom", collision: "flipfit"}
  });
  if ($(element).is(":focus")) {$(element).tooltip("open");}
};

var reglas = {
		reporte:"valcomboreq",
};

var mensajes = {
		reporte:"Se requiere este campo",
};

function verval(element){
	$("#tdependencia").rules("add",{
		valcomboreq: true,
		messages:{valcomboreq: "Se requiere este campo"}
	});
};

function delval(element){
	valcomboreqocultar("divd");
	$("#tdependencia").removeClass("error").css("border","");
	$("#tdependencia").rules("remove");
};

function valcaso(element){
	$("#asunto").rules("add",{
		required:true,
		minlength:15,
		maxlength:15,
	    messages:{
	      required:"Se requiere este campo",
	      minlength:"Debe tener 15 caracteres",
	      maxlength:"Debe tener 15 caracteres",
	    }
	});
};

function delcaso(){
	$("#asunto").removeAttr("title").removeClass("error").css("border","");
	$("#asunto").rules("remove");
};

function totaltabla(valor) {
	var resultado = 0;
	$('#example tbody tr').each( function() {
		var cel = $('td', this);
		var campoa = $(cel[1]).text();
		resultado += parseInt(campoa);
	});
	return resultado;
};

//*******************************************************************************************
$(document).ready(function() {
	$("#expgrafico").click(function () {
		var chart = $('#container').highcharts();
	    $.ajax({
	    	type: "GET",
	    	url: chart.exportChart(),
		    dataType: "script",
		});
    });

	$('.fecharangolimit366hoy').dateRangePicker({
		format: 'DD-MM-YYYY',
		separator : ' al ',
		language: 'custom',
		startDate: '01-01-2010',
		endDate: fecha_act.substring(0, 10),
		minDays: 1,
		maxDays: 366,
		getValue: function()
		{
			return this.innerHTML;
		},
		setValue: function(s)
		{
			this.innerHTML = s;
		},
		shortcuts : null,
		customShortcuts:
		[{
				name: 'Mes ant.',
				dates : function()
				{
					var start = moment().subtract('months', 1).startOf('month').toDate();
					var end = moment().subtract('months', 1).endOf('month').toDate();
					return [start,end];
				}
			},{
				name: 'Lo que va de mes.',
				dates : function()
				{
					var start = moment().startOf('month').toDate();
					var end = moment().toDate();
					return [start,end];
				}
			},{
				name: 'Mes act.',
				dates : function()
				{
					var start = moment().startOf('month').toDate();
					var end = moment().endOf('month').toDate();
					return [start,end];
				}
			}
		]
	}).bind('datepicker-apply',function(event,obj){
		console.log(obj);
	});

	fecha_act = $("#fecha_act").val();
	$("#ver").click(function(){
    	verval();
    });

    $("#quitar").click(function(){
    	delval();
    });

    var validator = $("#validacion").bind("invalid-form.validate", function() {
//      $("#summary").html("Your form contains " + validator.numberOfInvalids() + " errors, see details below.");
    }).validate({
      debug: true,
      ignore: ".select2-input, .select2-focusser",
      showErrors: function(map, list) {
        var focussed = document.activeElement;
            if ($(focussed).is(":focus") && $(focussed).is("input, textarea")) {
              // alert("si tiene el focus y es un input");
              $(focussed).tooltip();
              $(focussed).tooltip("close");
            }
        this.currentElements.removeAttr("title").removeClass("error");
        // ocultar(this.currentElements);
            $.each(list, function(index, error) {
              // alert("Mensaje de error: " + error.message);
              $(error.element).tooltip();
              $(error.element).tooltip("close");
                $(error.element).attr("title", error.message).addClass("error");
                mostrar(error.element);
            });
        },
      submitHandler: function() {
//         alert("Todo listo fino, validado." + "\n" + "Y sigue el proceso.");
    	  procesar();
      },
      rules: reglas,
      messages: mensajes
    });

	$("#volver").click(function(){
		$("table > thead >").remove();
		miTabla.fnClearTable();
		miTabla.fnDestroy();
		$("#datos").hide();
		$("#criterios").show();
	});

	$("#cancelar").click(function(){
		$(location).attr("href",ruta + "/caso/principal");
	});

	$.post(ruta+'/ponencia/crear/reportes', function(opts){
		$("#reporte").select2({
			placeholder: "Seleccione...",
			data:{ results: opts.registros, id:'id', text: 'text' },
			formatSelection: format,
			formatResult: format
    	}).on('change', function(e){
    		$("#cki").hide();
    		delval();
    		$("#dependencia").blur();
    		$("#reporte").blur();
    		caso0();
    		fechadinamic(32);
    		var nrocaso = parseInt($("#reporte").select2("val"));
//    		alert("Reporte: " + nrocaso);
    		delcaso(asunto);
    		switch (true) {
	    	    case (nrocaso == 1):
	    	    	$('#div1d').unblock();$('#divt').unblock();break;
	    	    case (nrocaso == 2):
	    	    	$('#div1ta').unblock();break;
	    	    case (nrocaso == 3):
	    	    	$('#div1me').unblock();break;
	    	    case (nrocaso == 5 || nrocaso == 11 || nrocaso == 12 ):
	    	    	caso1();break;
	    	    case (nrocaso == 8):
	    	    	caso1();$('#div1me').block({ message: null });break;
	    	    case (nrocaso == 6 ):
	    	    	valcaso(asunto);
	    	    	$('#divasunto').unblock();break;
	    	    case (nrocaso == 13):
	    	    	valcaso(asunto);
	    	    	$('#divasunto').unblock();break;
	    	    case (nrocaso == 9):
	    	    	fechalimit(366, fecha_act);
	    	    	caso1();$('#div1r').block({ message: null });break;
	    	    case (nrocaso == 7):
	    	    	caso1();$('#div1r').block({ message: null });break;
	    	    case (nrocaso == 4 ):
	    	    	fechadinamic(366);
	    	    	caso1();$('#div1me').block({ message: null });$('#div1r').block({ message: null });break;
	    	    case (nrocaso == 10):
	    	    	$('#div1r').unblock();break;
	    	    case (nrocaso == 14 || nrocaso == 16 || nrocaso == 17):
	    	    	fechalimit(366, fecha_act);
	    	    	caso1();
	    	    	$('#div1ta').block({ message: null });
	    	    	$('#div1d').block({ message: null });
	    	    	$('#div1me').block({ message: null });
	    	    	$('#div1r').block({ message: null });
	    	    	break;
	    	    case (nrocaso == 15):
	    	    	fechalimit(366, fecha_act);
	    	   	    $('#divFechaspan').unblock();
		    		$('#div1d').unblock();
	    	    	break;
	    	    case (nrocaso == 18 ):
	    	    	fechalimit(366, fecha_act);
	    	    	$('#divFechaspan').unblock();
	    	       	break;
    		};
    	});
	});

	$.post(ruta+'/ponencia/crear/audiencias', function(opts){
		$("#ta").select2({
				placeholder: "Seleccione...",
				allowClear: true,
				data:{ results: opts.registros, id:'id', text: 'text' },
				formatSelection: format,
				formatResult: format
		});
	});
	$.post(ruta+'/ponencia/crear/dependencias', function(opts){
		$("#tdependencia").select2({
				placeholder: "Seleccione...",
				allowClear: true,
				data:{ results: opts.registros, id:'id', text: 'text' },
				formatSelection: format,
				formatResult: format
		}).on('change', function(e){
			$("#tdependencia").blur();
			var nrocaso = parseInt($("#reporte").select2("val"));
			if(nrocaso != 15){
				$.post(ruta+'/ponencia/crear/tribunales?organo='+ $("#tdependencia").select2("val"), function(opts){
					if(opts.total == 0){$('#div1t').block({ message: null });}
					else{$('#div1t').unblock();};
					$('#divt').block({ message: null });
					cleanCombo("#tribunal");
					$("#ckt").removeAttr("checked");
	            	$("#tribunal").select2({
	                    placeholder: "Seleccione...",
	                    allowClear: true,
	                    data:{ results: opts.registros, id:'id', text: 'text' },
	                    formatSelection: format,
	                    formatResult: format
	            	});
				});
			};
		});
	});

	$.post(ruta+'/ponencia/crear/motivoestado', function(opts){
		$("#motivoestado").select2({
				placeholder: "Seleccione...",
				allowClear: true,
				data:{ results: opts.registros, id:'id', text: 'text' },
				formatSelection: format,
				formatResult: format
		}).on("change", function(e){
			$("#ckr").attr('checked',false);
			$("#responsabilidad").select2('data', null);
			$("#divr").block({ message: null });
			cleanCombo("#responsabilidad");
		});
	});

	$("#date-range9").click(function(){
		$( ".blockUI" ).css( "z-index", "1" );
	});

	$("#ckr").on('change', function () {
		var valor = $("#motivoestado").select2("val");
		if ($(this).is(':checked')){
			if (valor == ""){
				llenaResponsabilidad("responsabilidad");
			}else{
				llenaResponsabilidad("responsabilidadfil?motivo=" + $("#motivoestado").select2("val"));
			};
		};
	});

	$("#ckt").on('change', function () {
		var nrocaso = parseInt($("#reporte").select2("val"));
		if(nrocaso == 7 || nrocaso == 8){
			if ($(this).is(':checked')){
				$("#cki").show();
			}else{
				$("#cki").attr('checked',false);$("#cki").hide();
			};
		}else{
			$("#cki").attr('checked',false);$("#cki").hide();
		};
	});

	$("#ckd").on('change', function () {
		// programar si es el reporte que corresponde y llamar a la función
		var nrocaso = parseInt($("#reporte").select2("val"));
		if(nrocaso == 15){
			if ($(this).is(':checked')){
				verval();
			}else{
				delval();
			};
		}else{
			delval();
		};
		$("#ckt").attr('checked',false);
		$("#tribunal").select2('data', null);
		$("#div1t").block({ message: null });
	});

	$("#ckme").on('change', function () {
		$("#ckr").attr('checked',false);
		$("#responsabilidad").select2('data', null);
		$("#divr").block({ message: null });
	});

	$("#exp2").click(function(){
		$.ajax({
		      type: "GET",
		      url: exportar(this,"EstaAudi.xls", "Audiencia"),
		      dataType: "script",
		});
	});

	Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
	    return {radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },stops: [[0, color],[1, Highcharts.Color(color).brighten(-0.3).get('rgb')]]};
	});

	$("#grafico").click(function(){
		var nrocaso = parseInt($("#reporte").select2("val"));
		var registros = $('#example >tbody >tr').length;
//		if ((registros > 3)){
//			alert("Verifique; m\u00e1ximo regristros a graficar para este reporte son 5. \n Reduzca el listado o filtre la informacaci\u00f3n");
//			return false;
//		};
//		if ((nrocaso == 4) && (registros > 5)){
//			alert("Verifique; m\u00e1ximo regristros a graficar para este reporte son 5. \n Reduzca el listado o filtre la informacaci\u00f3n");
//			return false;
//		};
//		if ((nrocaso == 7) && (registros > 10)){
//			alert("Verifique; m\u00e1ximo regristros a graficar para este reporte son 10. \n Reduzca el listado o filtre la informacaci\u00f3n");
//			return false;
//		};

		var data = $("#reporte").select2("data");delete data.element;
		$('#divgrafico').dialog('open');
		var titulo = JSON.parse(JSON.stringify(data.text));
		var subtitulo = ' Desde ' + FIg + ' al ' + FFg;
		if ($("#ta").val() != "" && $("#ta").val() != ""){
				subtitulo += " " + $("#ta").val();
		};
		// Tipo de dependencia
		if ($("#tdependencia").val() != ""){
			data = $("#tdependencia").select2("data");delete data.element;
			subtitulo += " " + JSON.parse(JSON.stringify(data.des1));
		};
		if ($('#ckr').is(':checked')){
			if ($("#responsabilidad").val() != ""){
				data = $("#responsabilidad").select2("data");delete data.element;
				subtitulo += " " + JSON.parse(JSON.stringify(data.des1));
			};
		}else{
			if ($("#motivoestado").val() != ""){
				data = $("#motivoestado").select2("data");delete data.element;
				subtitulo += " " + JSON.parse(JSON.stringify(data.des2));
			};
		};
//		alert("ID reporte: " + nrocaso);
		if (nrocaso == 7 || nrocaso == 8){
			$('#container').highcharts({
				chart: {
	            	type: 'column',
	            	margin: [70, 90, 60, 70],
	                options3d: {
	                        enabled: true,
	                        alpha: 8,
	                        beta: 8,
	                        depth: 60,
	                        viewDistance: 50
	                }
	            },
	            legend: {
	                enabled: false
	            },
	            data: {table: document.getElementById('example')},
	            yAxis: {
	            	opposite: true,
	                minorGridLineDashStyle: 'longdash',
	                minorTickInterval: 'auto',
	                minorTickWidth: 0,
	                title: {text: 'Audiencias', style:	{color: '#CE140B'}},
	                labels: {
                        format: '{value} ',
                        style:	{color: '#CE140B'}
	                }
	            },
	            title: {text: titulo },
	            subtitle: {
	            	text: '<b>' + subtitulo + '<b><br><b>Total: ' + totaltabla() + '<b>',
//	            	style:	{color: '#CE140B'},
	                floating: true,
	                align: 'left',
	                x: 60,
//	                y: 50
	            },
	            tooltip: {
	                formatter: function() {
	                    return '<b>'+ this.series.name +': '+ this.y + '</b><br/>';
	                },
	                borderWidth: 3,
	            },
	            plotOptions: {
	                series: {
	                    dataLabels: {
	                        enabled: true,
	                        style: {
	                            fontWeight:'bold',
//	                            color: '#5B5753'
	                            color: '#CE140B'
	                        },
	                        x: 0,
	                        y: -30
	                    }
	                }
	            },
	            navigation: {
	                buttonOptions: {
	                    enabled: false
	                }
	            },
		        exporting: {
		            type: 'application/pdf',
		        },
	        });
		}else if (nrocaso == 14 || nrocaso == 15 || nrocaso == 16 || nrocaso == 17){
			$('#container').highcharts({
		        data: {
		            table: document.getElementById('example')
		        },
		        chart: {
		            type: 'pie'
		        },
		        title: {text: titulo },
	            subtitle: {
	            	text: '<b>' + subtitulo + '<b><br><b>Total: ' + totaltabla() + '<b>',
//	            	style:	{color: '#CE140B'},
	                floating: true,
	                align: 'left',
	                x: 60,
//	                y: 50
	            },
		        yAxis: {
		            allowDecimals: false,
		            title: {
		                text: 'Units'
		            }
		        },
		        tooltip: {
		        	formatter: function () {
		        		return '<b>' + this.point.name + '<br/> ' + this.point.y + ' </b>';
		            },
		            borderWidth: 3,
		        },
		        plotOptions: {
		            pie: {
		                allowPointSelect: true,
		                cursor: 'pointer',
		                dataLabels: {
		                    enabled: true,
		                    format: '<b>{point.name}</b>: <b>{point.y} = {point.percentage:.1f}%</b>',
		                    style: {
		                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
		                    }
		                },
		                dataLabels: {
		                    enabled: true,
		                    format: '<b>{point.name}</b>: <b>{point.y} = {point.percentage:.1f} %</b>',
		                    style: {
		                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
		                    },
		                    connectorColor: 'silver'
		                },
		                showInLegend: true
		            }
		        },
		        navigation: {
	                buttonOptions: {
	                    enabled: false
	                }
	            },
		        exporting: {
		            type: 'application/pdf',
		        },
		    });
		}else{
			$('#container').highcharts({
				chart: {
	            	type: 'column',
	            	margin: [70, 90, 60, 70],
	                options3d: {
	                        enabled: true,
	                        alpha: 8,
	                        beta: 8,
	                        depth: 60,
	                        viewDistance: 50
	                }
	            },
	            data: {table: document.getElementById('example')},
	            yAxis: {
	            	opposite: true,
	                minorGridLineDashStyle: 'longdash',
	                minorTickInterval: 'auto',
	                minorTickWidth: 0,
	                title: {text: 'Audiencias'}
	            },
	            title: {text: titulo },
	            subtitle: {
	            	text: '<b>' + subtitulo + '<b><br><b>Total: ' + totaltabla() + '<b>',
//	            	style:	{color: '#CE140B'},
	                floating: true,
	                align: 'left',
	                x: 60,
//	                y: 50
	            },
	            tooltip: {
	                formatter: function() {
	                    return '<b>'+ this.series.name +': '+ this.y + '</b><br/>';
	                },
	                borderWidth: 3,
	            },
	            plotOptions: {
	                series: {
	                    dataLabels: {
	                        enabled: true,
	                        style: {
	                            fontWeight:'bold',
//	                            color: '#5B5753'
	                            color: '#CE140B'
	                        },
	                        x: 0,
	                        y: -30
	                    }
	                }
	            },
	            navigation: {
	                buttonOptions: {
	                    enabled: false
	                }
	            },
		        exporting: {
		            type: 'application/pdf',
		        },
	        });
		};
	});

	$('#divgrafico').dialog({
	    dialogClass: "no-close",
	    autoOpen: false,
	    show: {effect: 'fade', duration: 500}, // Efecto al abrir el dialogo
	    hide: {effect: 'fade', duration: 500}, // Efecto al cerrar el dialogo
	    resizable: false,
	    closeOnEscape: true,
	    draggable: false,
	    modal: true,
	    width: 1000,
	    height: 550,
//	    buttons: {
//	    	"Volver": function () {
//	    		$(this).dialog("close");
//	    	}
//	    }
	});

	$("#expgraficovolver").click(function () {
		$("#divgrafico").dialog("close");
    });

	$("#datos").hide();
	var valor = $.datepicker.formatDate('dd-mm-yy', new Date());
	$('#date-range9').text(valor + " al " + valor);
	$('#reporte').val(5);
	caso0();
	caso1();

	actcheck("#ckta", "#divta", "#ta");
	actcheck("#ckd", "#divd", "#tdependencia");
	actcheck("#ckt", "#divt", "#tribunal");
	actcheck("#ckme", "#divme", "#motivoestado");
	actcheck("#ckr", "#divr", "#responsabilidad");
	// Inicializar combo
	cleanCombo("#tribunal");
	cleanCombo("#responsabilidad");
	$("#cki").hide();
});