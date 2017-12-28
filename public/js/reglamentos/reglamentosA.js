var Registroreglamento = '';
var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};
var ManejoRespuestaE = function(respuesta){
    if (respuesta.code=!'200'){
        mensajesAlerta('Error!','Contacte al personal informático', 'error');
        return 0;
    }else{
        if (respuesta.respuesta.f_registro_reglamento[0].f_registro_reglamento=='200'){
            mensajesAlerta('Procesado!','Borrado con exito.', 'info');
            destruirTablaS('tablaReglamentos');
            cargarTablaReglamentos(respuesta.respuesta.v_reglamentos);
            return 0;
        }else{
            mensajesAlerta('Error!','Contacte al personal informático', 'error');
            return 0;
        }
    }
};
var cargarTablaReglamentos = function(data){
    $("#tablaReglamentos").dataTable({
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
        {"title": "Id","data": "id_reglamento",visible:0},
        {"title": "Tipo Reglamento","data": "des_tipo_reglamento"},
        {"title": "Reglamento","data": "des_reglamento"},
        {"title": "Fecha de Carga","data": "fecha", "width":"18%"},
        {"title": "Activo","data": "estatus",visible:0},
        {"title": "Sede","data": "id_sede",visible:0}
        ],
    });
};
var Boton_agregar = function(data){
    $('#divTabla').hide();
    $('#divForm').show();
    $("#id_reglamento").val("");
    $('#Formreglamento')[0].reset();
    $(".comboclear").val('').trigger("change");
}
var Boton_cancelar = function(){
    $('#divForm').hide();
    $('#divTabla').show();
    $("#cancelar").html(" Cancelar");
}
var eliminarLey= function(data){
    parametroAjax.ruta=rutaE;
    parametroAjax.data=data;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaE(respuesta);
}
var ProcesarReglamento = function(){ 
    var formu=$(this);
    var nombreform=$(this).attr("id");
    var form = $('#Formreglamento').get(0); 
    var formData = new FormData(form);
        //hacemos la petición ajax  
        $.ajax({
            url: rutaC,  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //una vez finalizado correctamente
            success: function(data){   
            var res=JSON.parse(data.f_registro_reglamento);
                switch(res.code) {
                    case "-2":
                        mensajesAlerta('Error!',res.des_code, 'error');
                    break;
                    case "200":
                        mensajesAlerta('Procesado!',res.des_code, 'info');
                        destruirTablaS('tablaReglamentos');
                        cargarTablaReglamentos(data.v_reglamentos);
                        Boton_cancelar();
                    break;    
                    default:
                        mensajesAlerta('Error!','Error de registro. Intente nuevamente, si el error persite contacte al personal informático.', 'error');
                } 
            },
            error: function(data){
               mensajesAlerta('Error!','ha ocurrido un error al cargar su reglamento', 'error');
            },
        });
};
var crearallcombos = function(data){
    crearcombo('#id_tipo',data);
}
var validarR=function(){$('#Formreglamento').formValidation('validate');};
$(document).ready(function(){
    cargarTablaReglamentos(d.v_reglamentos);
    crearallcombos(d.v_tipo);
    var tableB = $('#tablaReglamentos').dataTable();
    $('#tablaReglamentos tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        Registroreglamento = TablaTraerCampo('tablaReglamentos',this);
    });
    tableB.on('dblclick', 'tr', function () {
        $('#close').trigger('click');
    });
     $(function() {
        $.contextMenu({
            selector: '#tablaReglamentos',
            callback: function(key, options){
                switch(key) {
                    case "1":
                        OpenWindowWithPost(rutaD,'','_blank',Registroreglamento);
                        break;
                    case "2":
                        eliminarLey(Registroreglamento);    
                        break;
                }
            },
            items: {
                "1": {name: "Visualizar", icon: "edit"},
                "2": {name: "Eliminar", icon: "delete"},
            }
        });
    });
    $(document).on('click','#guardar',validarR);
    $(document).on('click','#cancelar',Boton_cancelar);
    $(document).on('click','#agregar',Boton_agregar);

  $('#Formreglamento').formValidation({
        // message: 'El módulo le falta un campo para ser completado',
        rules: {
            'urlreglamento': {
              required: true
            }
        },
        fields: {
            'urlreglamento': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 4*1024*1024,   // 5 mg
                        message: 'Debe seleccionar un archivo pdf no mayor a 4 megabytes (MB)'
                    }
                }
            },
             'des_reglamento': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
        }
    }).on('success.form.fv', function(e){
        ProcesarReglamento();
    }).on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});