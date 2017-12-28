var RegistroComite = casos='';
var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var cargarTablaComite = function(data){
    $("#tablaComite").dataTable({
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
        {"title": "Id","data": "user_id",visible:0},
        {"title": "rut","data": "rut"},
        {"title": "Nombres","data": "name"},
        {"title": "Cargo del Comité","data": "cargo"},
        {"title": "Sede","data": "sede_usuario",visible:0}
        ],
    });
};


var cargarTabla = function(){
    limpiar();
    $('#divForm').hide();
    $('#divTabla').show();
    $('.divCam').hide();
    $("#cancelar").html(" Cancelar");
}


var CargarComite = function(data){
    // $("#myModal").modal();
     $('#myModal2').window('open');
    if(data.user_id!=null){$("#user_id").val(data.user_id);}
}


var EliminarComite = function(data){
    caso=2;
    casos = {'caso': caso}
    if(data.user_id!=null){$("#user_id").val(data.user_id);}
    parametroAjax.data = $("#FormComite").serialize() + '&' + $.param(casos);
    parametroAjax.ruta=ruta;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarComite(respuesta);
}


var ProcesarComite = function(){
    caso=1;
    casos = {'caso': caso}
    parametroAjax.data = $("#FormComite").serialize() + '&' + $.param(casos);
    parametroAjax.ruta=ruta;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarComite(respuesta);
};

var ManejoRespuestaProcesarComite = function(respuesta){
    switch(respuesta.respuesta.value.code){
        case '200':
            $('#myModal2').window('close');
            limpiarTabla();
            cargarTablaComite(respuesta.respuesta.vista_comite);
            mensajesAlerta('Procesado!','Registro éxitoso', 'info');
            break;
        case '300':
            limpiarTabla();
            cargarTablaComite(respuesta.respuesta.vista_comite);
            mensajesAlerta('Procesado!','Eliminado éxitosamente', 'info');
            break;
        default:
           mensajesAlerta('Error','Se ha encontrado un error comunicarse con el personal informático', 'error');
    }
}

var CerrarC = function(){$('#myModal2').window('close');};
var limpiarTabla = function(){destruirTablaS('tablaComite');};
var validarC=function(){$('#FormComite').formValidation('validate');};

$(document).ready(function(){
    $("#tituloPantalla").text(d['title']);
    cargarTablaComite(d.v_personas_comites);
    $(document).on('click','#guardarC',validarC);
    $(document).on('click','#cerrarC',CerrarC);
    var tableB = $('#tablaComite').dataTable();
    $('#tablaComite tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroComite= TablaTraerCampo('tablaComite',this);
    });
    tableB.on('dblclick', 'tr', function () {
        $('#close').trigger('click');
    });
    $(function() {
        $.contextMenu({
            selector: '#tablaComite',
            callback: function(key, options) {
                switch(key) {
                    case "1":
                        CargarComite(RegistroComite);
                        break;
                    case "2":
                        EliminarComite(RegistroComite);
                        break;
                }
            },
            items: {
                "1": {name: "Asignar", icon: "edit"},
                "2": {name: "Eliminar", id:"Editar", icon: "delete"},
            }
        });
    });
    $('#FormComite').formValidation({
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'cargo': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
        }
    }).on('success.form.fv', function(e){
        ProcesarComite();
    }).on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});
