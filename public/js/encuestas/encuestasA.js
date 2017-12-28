var RegistroEncuestas=RegistroOpciones='';
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
    	var res = JSON.parse(respuesta.respuesta.f_registro_encuesta[0].f_registro_encuesta);
    	switch(res.code) {
    	    case '200':
                mensajesAlerta('Procesado!',res.des_code, 'info');
                destruirTablaS('tablaEncuestas');
                cargarTablaEncuestas(respuesta.respuesta.v_encuestas);
                $("#id_encuesta").val(res.id_encuesta);
                $("#id_encuesta2").val(res.id_encuesta);
                $('#divCargar').show();
                $('#divGuardar').hide();
    	        break;
    	    case '-2':
    	        mensajesAlerta('Error',res.des_code, 'error');
    	        break;
    	    default:
    	        mensajesAlerta('Error','Comuniquese con el personal de sopore técnico', 'error');
    	}
    }else{
        mensajesAlerta('Error','Comuniquese con el personal de sopore técnico', 'error');
    }
};
var ManejoRespuestaO = function(respuesta){
    if (respuesta.code=='200'){
        $('#modalOpciones').window('open');
        cargarTablaOpciones(respuesta.respuesta.v_opciones);
    }else{
        mensajesAlerta('Error','Comuniquese con el personal de sopore técnico', 'error');
    }
};
var ManejoRespuestaE = function(respuesta){
    if (respuesta.code=='200'){
        destruirTablaS('tablaEncuestas');
        cargarTablaEncuestas(respuesta.respuesta.v_encuestas);
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
    if (respuesta.code=='200'){
        var contenedor = $("#divResultados");
        $(jQuery.parseJSON(JSON.stringify(respuesta.respuesta))).each(function(){
        $(contenedor).append('<div class="row"><b>'+this.titulo+':   </b>'+this.valor+' voto(s) de '+this.poblacion+'</div><div class="row"><progress id="bar" value="'+this.valor+'" max="'+this.poblacion+'"><em>12/20 components completed</em></progress></div>');
        });
    }else{
        mensajesAlerta('Error','Comuniquese con el personal de sopore técnico', 'error');
    }
};
var cargarTablaOpciones = function(data){
    $("#tablaOpcion").dataTable({
        "paging":   false,
        "searching": false,
        "info": false,
        "columnDefs": [
        {
            "targets": -1,
            "data": null,
            "targets": [ 1 ],
            "searchable": true,
        }
        ],
        "language": {
            "url": "/DataTables-1.10.10/de_DE-all.txt"
        },
        "data": data,
        "columns":[
        {"title": "Id","data": "id_opcion",visible:0},
        {"title": "Opción","data": "titulo"}
        ],
    });
};
var cargarTablaEncuestas = function(data){
    $("#tablaEncuestas").dataTable({
        "paging":   true,
        "searching": true,
        "info": false,
        "ordering": false,
        "displayLength": 20,
        "language": {
            "url": "/DataTables-1.10.10/de_DE-all.txt"
        },
        "data": data,
        "columns":[
            {"title": "Id encuesta","data": "id_encuesta",visible:0},
            {"title": "Fecha","data": "fecha",visible:0},
            {"title": "Fecha","data": "fecha_formato", "width":"10%"},
            {"title": "Título","data": "titulo", "width":"30%"},
            {"title": "Descripción","data": "ini_descripcion", "width":"50%"}
        ],
    });
};
var Boton_agregar = function(){
    $('#divCargar').hide();
    $('#divGuardar').show();
    $("#spanTitulo").text("Registro de encuestas");
    $(".divForm").toggle();
    $('#FormEncuestas')[0].reset();
    $("#id_encuesta").val("");
    $(".comboclear").val('').trigger("change");
}
var Boton_cancelar = function(){
    $('#divCargar').hide();
    $('#divGuardar').hide();
    $("#spanTitulo").text("Encuestas");
    $(".divForm").toggle();
    $('#FormEncuestas')[0].reset();
    $("#id_encuesta").val("");
    $(".comboclear").val('').trigger("change");
    $("#titulo").prop("readonly",false);
    $("#descripcion").prop("readonly",false);
}
var pintarDatosActualizar= function(data){
    $(".divForm").toggle();
    $('#divCargar').show();
    $('#divGuardar').hide();
    $("#spanTitulo").text("Actualización de encuestas");
    if(data.id_encuesta!=null){$("#id_encuesta").val(data.id_encuesta);}
    if(data.id_encuesta!=null){$("#id_encuesta2").val(data.id_encuesta);}
    if(data.titulo!=null){$("#titulo").val(data.titulo);}
    if(data.descripcion!=null){$("#descripcion").val(data.descripcion);}
    $("#titulo").prop("readonly",true);
    $("#descripcion").prop("readonly",true);
}
var ProcesarEncuesta = function(){
    if($('#titulo').val()==""){
        $('#titulo').closest('.form-group').addClass('has-error');
        return;
    }
    $('#titulo').closest('.form-group').removeClass('has-error');

    parametroAjax.data = $("#FormEncuestas").serialize();
    parametroAjax.ruta=ruta;
    respuesta=procesarajax(parametroAjax);
	ManejoRespuestaProcesar(respuesta);
};
var mostrarOpciones = function(){
    var id_encuesta = $('#id_encuesta2').val();
    parametroAjax.data = {'id_encuesta':id_encuesta}
    parametroAjax.ruta=rutaO;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaO(respuesta);
}
var ProcesarOpciones = function(){
    if($('#opcion').val()==""){
        $('#opcion').closest('.form-group').addClass('has-error');
        return;
    }
    $('#opcion').closest('.form-group').removeClass('has-error');

    parametroAjax.data = $("#FormOpciones").serialize();
    parametroAjax.ruta=rutaP;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaP(respuesta);
}
var EliminarEncuesta = function(data){
    parametroAjax.data = data;
    parametroAjax.ruta=rutaD;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaE(respuesta);
}
var volverOpciones = function(){
    destruirTablaS('tablaOpcion');
    $("#opcion").val("");
    $('#modalOpciones').window('close');
}
var volverTabla = function(){
    $('#modalResultados').window('close');
    $('#divResultados').empty();
    $("#spanTituloEncuesta").text(" ");
}

var verResultados = function(data){
    parametroAjax.data = data;
    parametroAjax.ruta=rutaR;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaR(respuesta);
    $("#spanTituloEncuesta").text(data.titulo);
    $("#spanDescripcionEncuenta").text(data.descripcion);
    $('#modalResultados').window('open');
}

var validarO=function(){$('#FormOpciones').formValidation('validate');};
var validarE=function(){$('#FormEncuestas').formValidation('validate');};
$(document).ready(function(){
	$("#spanTitulo").text("Encuestas");
    $("#activo").attr("checked",true);

    cargarTablaEncuestas(d.v_encuestas);


    var tableB = $('#tablaEncuestas').dataTable();
    $('#tablaEncuestas tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroEncuestas = TablaTraerCampo('tablaEncuestas',this);
    });
    tableB.on('dblclick', 'tr', function () {
        $('#close').trigger('click');
    });
     $(function() {
        $.contextMenu({
            selector: '#tablaEncuestas',
            callback: function(key, options) {
                switch(key) {
                    case "1":
                        pintarDatosActualizar(RegistroEncuestas);
                        break;
                    case "2":
                        EliminarEncuesta(RegistroEncuestas);
                    break;
                    case "3":
                        verResultados(RegistroEncuestas);
                    break;
                }
            },
            items: {
                "1": {name: "Editar", icon: "edit"},
                "2": {name: "Eliminar", icon: "delete"},
                "3": {name: "Ver resultados", icon: "add"},
            }
        });
    });
    $(document).on('click','#agregar',Boton_agregar);
    $(document).on('click','#cancelar',Boton_cancelar);
    $(document).on('click','#guardar',validarE);
    $(document).on('click','#cargar',mostrarOpciones);
    $(document).on('click','#guardarO',validarO);
    $(document).on('click','#cancelarO',volverOpciones);
    $(document).on('click','#cancelarR',volverTabla);



    $('#FormEncuestas').formValidation({
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'titulo': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
        }
    })
	.on('success.form.fv', function(e){
	    ProcesarEncuesta();
	})
	.on('status.field.fv', function(e, data){
	    data.element.parents('.form-group').removeClass('has-success');
	});

    $('#FormOpciones').formValidation({
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'opcion': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
        }
    })
    .on('success.form.fv', function(e){
        ProcesarOpciones();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});