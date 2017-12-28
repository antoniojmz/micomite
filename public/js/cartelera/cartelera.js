var Registrocartelera='';
var id_usuario_cartelera=0;
var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};
var pintarDatosActualizar= function(data){
    if(data.id_cartelera!=null){$("#id_cartelera").val(data.id_cartelera);}
    if(data.descripcion!=null){$("#descripcion").val(data.descripcion);}
    if(data.titulo!=null){$("#titulo").val(data.titulo);}
    if(!data.prioridad){
        // prioridad Media
        $("#prioridadB").attr('checked', true);
        $("#prioridadA").attr('checked', false);
    }else{
        // prioridad Alta
        $("#prioridadA").attr('checked', true);
        $("#prioridadB").attr('checked', false);
    }
    if(!data.estatus){
        $("#estatus").prop("checked",false);
    }else{
        $("#estatus").prop("checked",true);
    }
    if(data.fecha!=null){ $("#fecha").val(moment(data.fecha).format('DD/MM/YYYY'));}
    // $("#cancelar").html(" Volver");
}
/************************************************************* FUNCIONES **/
var cargarTablaCartelera = function(data){
    $("#tablaCarteleras").dataTable({
        // lengthMenu:[[7,15,-1],[7,15,"Todo"]],
        "paging":   true,
        "searching": true,
        "info": false,
        "order": [],
        "columnDefs": [
            {orderable:false,targets: [0,1,2,3,4]},
        ],
        "displayLength": 20,
        "language": {
            "url": "/DataTables-1.10.10/de_DE-all.txt"
        },
        "data": data,
        "columns":[
            {"title": "Id Cartelera","data": "id_cartelera",visible:0},
            {"title": "Fecha","data": "fecha_formato", "width": "10%" },
            {"title": "Usuario","data": "nombre_usuario","width":"20%"},
            {"title": "Aviso","data": "titulo","width":"60%"},
            {"title": "Prioridad","data": "des_prioridad","width":"10%"},
            {"title": "estatus","data": "estatus",visible:0},
        ],
        "fnCreatedRow": function(row,data,dataIndex){
            if (data.id_usuario_cartelera==null){
                $(row).css('background','#FFFD9F');
            }
        },
    });
};
var cargarForm = function(){
    $('#divTabla').hide();
    $('#divForm').show();
    $("#divGuardar").show();
    $("#id_cartelera").val("");
    $('#titulo').attr('readonly', false);
    $('#descripcion').attr('readonly', false);
    $('#FormCartelera')[0].reset();
    $(".comboclear").val('').trigger("change");
}
var volver = function(){
    $('#divTabla').show();
    $('#divForm').hide();
    if (id_usuario_cartelera==0){
        parametroAjax.ruta=rutaA;
        parametroAjax.data=Registrocartelera;
        respuesta=procesarajax(parametroAjax);
        ManejoRespuesta(respuesta);
    }
}
var ProcesarCartelera = function(){
    var id_cartelera=$('#id_cartelera').val();
    var descripcion= $('#descripcion').val();
    var titulo= $('#titulo').val();
    var estatus=false;
    var prioridad = true;
    if( $('#estatus').is(':checked') ){estatus=true;}
    if( $('input[name=prioridad]:checked', '#FormCartelera').val()=='1'){prioridad=false;}
    datos=[];
    datos = {
        id_cartelera:id_cartelera,
        descripcion:descripcion,
        prioridad: prioridad,
        estatus: estatus,
        titulo:titulo
    };
    parametroAjax.ruta=ruta;
    parametroAjax.data=datos;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesar(respuesta);
};
var ManejoRespuestaProcesar = function(respuesta){
    if (respuesta.code=200){
    var res = JSON.parse(respuesta.respuesta.f_registro_carteleras[0].f_registro_carteleras);
        switch(res.code) {
            case '200':
                var cartelera = JSON.parse(respuesta.respuesta.v_carteleras);
                destruirTablaS('tablaCarteleras');
                cargarTablaCartelera(cartelera);
                mensajesAlerta('Procesado!',res.des_code, 'info');
                $("#id_cartelera").val(res.id_cartelera);
                $('#divForm').hide();
                $('#divTabla').show();
                break;
            case '-2':
                mensajesAlerta('Error',res.des_code, 'error');
                break;
            default:
                mensajesAlerta('Error','Comuniquese con el personal de sopore técnico', 'error');
        }
    }else{
        mensajesAlerta('Error','Ocurrio un error al eliminar las imagenes', 'error');
    }
}
var verCartelera = function(data){
    if (data.id_usuario_cartelera!=null){id_usuario_cartelera=data.id_usuario_cartelera;}else{id_usuario_cartelera=0;}
    $("#divGuardar").hide();
    $("#descripcion").val(data.descripcion);
    $("#titulo").val(data.titulo);
    $("#fecha").text(data.fecha_formato);
    $("#divTabla").hide();
    $("#divTitulo").hide();
    $("#divForm").show();
    $('#descripcion').attr('readonly', true);
    $('#titulo').attr('readonly', true);
};
var ManejoRespuesta = function(respuesta){
    if (respuesta.code=200){
        destruirTablaS('tablaCarteleras');
        cargarTablaCartelera(respuesta.respuesta);
    }else{
        mensajesAlerta('Error','Ocurrio un error al eliminar las imagenes', 'error');
    }
};
var validarC=function(){$('#FormCartelera').formValidation('validate');};
$(document).ready(function(){
    if(d.id_nivel==2){$("#divPrioridad").show();}
    if(d.id_nivel==3){$("#divPrioridad").hide();}
    $(document).on('click','#guardar',validarC);
    $(document).on('click','#agregar',cargarForm);
    $(document).on('click','#cancelar',volver);
    $("#prioridadB").attr('checked', true);
    $("#tituloPantalla").text(d['title']);
    cargarTablaCartelera(d['v_carteleras_activas']);
    $('input[name=prioridad]:checked', '#FormCartelera').val();
    /*MENU DE EDITAR*/
    var tableB = $('#tablaCarteleras').dataTable();
    $('#tablaCarteleras tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        Registrocartelera = TablaTraerCampo('tablaCarteleras',this);
        verCartelera(Registrocartelera);
    });
    tableB.on('dblclick', 'tr', function () {
        $('#close').trigger('click');
    });
    $('#FormCartelera').formValidation({
        fields: {
            'descripcion': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'titulo': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            }
        }
    }).on('success.form.fv', function(e){
        ProcesarCartelera();
    }).on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});