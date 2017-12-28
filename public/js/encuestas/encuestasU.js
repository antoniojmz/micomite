var RegistroEncuestas='';
var combos=caso=0;
var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};
var ManejoRespuestaProcesar = function(respuesta){
    if (respuesta.code=='200'){
    	var res = JSON.parse(respuesta.respuesta.f_votar_encuesta[0].f_votar_encuesta);
    	switch(res.code) {
    	    case '200':
                mensajesAlerta('Procesado!',res.des_code, 'info');
                var data = JSON.parse(respuesta.respuesta.v_encuestasA);
                $('#divVotacion').empty();
                destruirTablaS('tablaEncuestas');
                cargarTablaEncuestas(data);
                $('.divRespuesta').hide();
                verResultados();
                $("#DivVotacion").hide();
                $("#DivResultado").show();
    	        break;
    	    case '-2':
    	        mensajesAlerta('Error',res.des_code, 'error');
    	        break;
    	    default:
    	        mensajesAlerta('Error','Comuniquese con el personal de sopore técnico', 'error');
            break;
    	}
    }else{
        mensajesAlerta('Error','Comuniquese con el personal de sopore técnico', 'error');
    }
};
var ManejoRespuestaO = function(respuesta){
    // console.log(respuesta);
    // console.log("entre en manejo respuesta O");
    $('#modalResultados').window('open');
    if (respuesta.code=='200'){
            $("#spanTituloEncuesta").text(RegistroEncuestas.titulo);
            $("#spanDescripcionEncuesta").text(RegistroEncuestas.descripcion);
        if(RegistroEncuestas.id_encuesta_propietario!=null){
            $("#DivResultado").show();
            $("#DivVotacion").hide();
            // console.log("vote en esta encuesta");
            $('.divRespuesta').hide();
            verResultados();
            caso=1;
        }else{
            $("#DivResultado").hide();
            $("#DivVotacion").show();
            // console.log("no vote en esta encuesta");
            $(".divResultado").toggle();
            var contenedor = $("#divVotacion");
            $(jQuery.parseJSON(JSON.stringify(respuesta.respuesta.v_opciones))).each(function(){
                $(contenedor).append('<div class="row"><div class="col-md-5"></div><div class="col-md-5"><input type="radio" name="voto" id="voto" value="'+this.titulo+'"><b> '+this.titulo+'</b></div></div>');
            });
            $('.divRespuesta').show();
        }
    }else{
        // console.log("estoy dando el msn de error");
        mensajesAlerta('Error','Comuniquese con el personal de sopore técnico', 'error');
    }
};
var ManejoRespuestaE = function(respuesta){
    if (respuesta.code=='200'){
        destruirTablaS('tablaEncuestas');
        cargarTablaEncuestas(respuesta.respuesta.v_encuestasA);
    }else{
        mensajesAlerta('Error','Comuniquese con el personal de sopore técnico', 'error');
    }
};

var ManejoRespuestaP = function(respuesta){
    if (respuesta.code=='200'){
        $("#opcion").val("");
        destruirTablaS('tablaOpcion');
        cargarTablaOpciones(respuesta.respuesta.v_opciones);
    }else{
        mensajesAlerta('Error','Comuniquese con el personal de sopore técnico', 'error');
    }
};
var ManejoRespuestaR = function(respuesta){
    // console.log("mostre resultados BARRAS");
    if (respuesta.code=='200'){
        var contenedor = $("#divResultados");
        $(jQuery.parseJSON(JSON.stringify(respuesta.respuesta))).each(function(){
        $(contenedor).append('<div class="row"><b>'+this.titulo+':   </b>'+this.valor+' voto(s) de '+this.poblacion+'</div><div class="row"><progress id="bar" value="'+this.valor+'" max="'+this.poblacion+'"><em>12/20 components completed</em></progress></div>');
        });
    }else{
        mensajesAlerta('Error','Comuniquese con el personal de sopore técnico', 'error');
    }
};
var cargarTablaEncuestas = function(data){
        // console.log(data);
        $("#tablaEncuestas").dataTable({
        "paging":   true,
        "searching": true,
        "ordering": false,
        "info": false,
        "targets": 0,
        "language": {
            "url": "/DataTables-1.10.10/de_DE-all.txt"
        },
        "data": data,
        "columns":[
            {"title": "Id","data": "id_encuesta",visible:0},
            {"title": "Fecha","data": "fecha",visible:0},
            {"title": "Fecha","data": "fecha_formato", "width":"10%"},
            {"title": "Título","data": "titulo", "width":"40%"},
            {"title": "Descripción","data": "ini_descripcion", "width":"50%"},
        ],
        "fnCreatedRow": function(row,data,dataIndex){
            if (data.id_encuesta_propietario==null){
                $(row).css('background','#FFFD9F');
            }
        },
    });
};
function recortarTexto(n) {

     if(n.length > 0 || n == null) {
          var cadena = n.slice(1, 3);
     }

  return n;
};
var Boton_agregar = function(){
    $('#divCargar').hide();
    $("#spanTitulo").text("Registro de encuestas");
    $(".divForm").toggle();
    $('#FormVotacion')[0].reset();
    $("#id_encuesta").val("");
    $(".comboclear").val('').trigger("change");
}
var Boton_cancelar = function(){
    if(caso==1){
        $("#spanEncuesta").text("");
        caso=0;
    }
    $('#FormVotacion')[0].reset();
    $("#id_encuesta").val("");
    $('#divVotacion').empty();

    $('#divCargar').hide();
    $("#spanTitulo").text("Encuestas");
    $(".divForm").toggle();

}
var ProcesarVotacion = function(){
    if($('input:radio[name=voto]:checked').val()==undefined){
        alert("Debe seleccionar una opción");
        return 0;
    }
    var id_encuesta = RegistroEncuestas.id_encuesta;
    var voto = $('input:radio[name=voto]:checked').val()
    parametroAjax.data = {'id_encuesta':id_encuesta,'voto':voto,}
    parametroAjax.ruta=rutaE;
    respuesta=procesarajax(parametroAjax);
	ManejoRespuestaProcesar(respuesta);
};
var mostrarOpciones = function(){
    // console.log("entre den la opcion");
    var id_encuesta = RegistroEncuestas.id_encuesta;
    parametroAjax.data = {'id_encuesta':id_encuesta}
    parametroAjax.ruta=rutaO;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaO(respuesta);
}

var volverTabla = function(){
    $('#modalResultados').window('close');
    $('#divResultados').empty();
    $("#spanTituloEncuesta").text(" ");
    if(caso==1){
        // $(".divRespuesta").toggle();
        $("#spanEncuesta").text("");
        caso=0;
    }
    $('#FormVotacion')[0].reset();
    $("#id_encuesta").val("");
    $('#divVotacion').empty();
}

var votarE = function(){
    $('#modalResultados').window('close');
}

var verResultados = function(){
    // console.log("entre a ver los resultados antes y despues de votar");
    // console.log(RegistroEncuestas);
    parametroAjax.data = RegistroEncuestas;
    parametroAjax.ruta=rutaR;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaR(respuesta);
    // $("#spanTituloEncuesta").text(RegistroEncuestas.titulo);
    // $("#spanDescripcionEncuesta").text(RegistroEncuestas.descripcion);
    // $('#modalResultados').window('open');
}

var validarV=function(){$('#FormVotacion').formValidation('validate');};
$(document).ready(function(){
	$("#spanTitulo").text("Encuestas");
    $("#activo").attr("checked",true);
    cargarTablaEncuestas(d.v_encuestasA);
    var tableB = $('#tablaEncuestas').dataTable();
    $('#tablaEncuestas tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroEncuestas = TablaTraerCampo('tablaEncuestas',this);
        mostrarOpciones(RegistroEncuestas);
        // console.log("hice click");
        // verResultados(RegistroEncuestas);

    });
    tableB.on('dblclick', 'tr', function () {
        $('#close').trigger('click');
    });

    $(document).on('click','#votar',validarV);
    $(document).on('click','#cancelar',Boton_cancelar);
    $(document).on('click','#cancelarR',volverTabla);
    // $(document).on('click','#guardar',validarV); votar
    $(document).on('click','#votarE',votarE);

    $('#FormVotacion').formValidation({
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            verbose: false,
            'voto': {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar una opcion'
                    }
                }
            },
        }
    })
	.on('success.form.fv', function(e){
	    ProcesarVotacion();
	})
	.on('status.field.fv', function(e, data){
	    data.element.parents('.form-group').removeClass('has-success');
	});
});