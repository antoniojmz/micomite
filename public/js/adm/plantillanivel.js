var v_id_modulos_poderes = 0;

var procesarajax = function(data, ruta, caso){
    $.ajax({
        url:ruta,
        headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
        type:'POST',
        async:false,
        dataType: 'JSON',
        data: data,
    })
    .done(function(response) {
        switch(caso) {
            case 1:
                    console.log(response);
                    $('#id_poder').empty();
                    $('#id_poder').select2({
                        'placeholder': "Seleccione...",
                        'data': response,
                        'language': "es"
                    });
                    break;
            case 2:
                destruirTabla();
                mensajesAlerta('Procesado!','Se eliminó con éxito.', 'info');
                actualizarDatos(response);
                var oTable = $('#TablaPerfilModulosPoderes').dataTable();
                oTable.fnFilter("^"+$('#id_perfil').val()+"$", 4, true);
                break;
            case 3:
                destruirTabla();
                mensajesAlerta('Procesado!','Se registró con éxito.', 'info');
                actualizarDatos(response);
        }
    })
    .fail(function (jqXHR, exception) {
        var msg = '';
        if (jqXHR.status === 0) {
            msg = 'Not connect.\n Verify Network.';
        } else if (jqXHR.status == 422){
                // console.log(jqXHR.responseJSON);
                // $.each(jqXHR.responseJSON, function (key, value) {
                //     // your code here
                //     $.gritter.add({
                //         title: 'Error',
                //         text: value
                //     });
                // });
                // $.each(errors, function(index, value) {
                //     $.gritter.add({
                //         title: 'Error',
                //         text: value
                //     });
                // });
        } else if (jqXHR.status == 404) {
            msg = 'Requested page not found. [404]';
        } else if (jqXHR.status == 500) {
            msg = 'Internal Server Error [500]. Si el error persiste comuníquese con informática.';
        } else if (exception === 'parsererror') {
            msg = 'Requested JSON parse failed.';
        } else if (exception === 'timeout') {
            msg = 'Time out error.';
        } else if (exception === 'abort') {
            msg = 'Ajax request aborted.';
        } else {
            msg = 'Uncaught Error.\n' + jqXHR.responseText;
        }
        mensajesAlerta('Error',msg, 'error');
    });
}

var deletemodulopoder = function (id_plantilla_nivel){
    $.messager.confirm('Confirmación', 'Seguro desea eliminar ' + id_plantilla_nivel.toString().split(",").length, function(r){
        if (r){
            procesarajax({'id_plantilla_nivel':id_plantilla_nivel}, datos.rutaDeletePlantillaNivel, 2);
            $("#id_poder").val(null).trigger("change");
            if (TablaNroRegistroFil('TablaPerfilModulosPoderes') > 0 ) menuC();
            filtrarPerfilModulos($('#id_perfil').val(), $('#id_modulo').val());
        }
    });
}

var addmodulopoder = function(){
    procesarajax(
            {   'id_perfil': $('#id_perfil').val(),
                'poderes': $('#id_poder').val(),
                'id_tipo_modulo_id_modulo' : $("#id_modulo").val()
            },
            datos.rutaAddPlantillaNivel, 3);
    $("#id_poder").val(null).trigger("change");
    var oTable = $('#TablaPerfilModulosPoderes').dataTable();
    oTable.fnFilter("^"+$('#id_perfil').val()+"$", 4, true);
    oTable.fnFilter("^"+$('#id_modulo').val()+"$", 2, true);
    $("#id_poder").val(null).trigger("change");
    if (TablaNroRegistroFil('TablaPerfilModulosPoderes') > 0 ) menuC();
}

var actualizarDatos = function (obj_datos){
    $("#TablaPerfilModulosPoderes").dataTable({
        aLengthMenu: [[4, 10, -1],[4, 10, "All"]],
        language: lenguajeTabla,
        data: obj_datos,
        "columns":[
            {"title": "Módulo","data": "des_cod_modulo"},
            {"title": "Poder","data": "des_poder"},
            {"title": "id_tipo_modulo_id_modulo","data": "id_tipo_modulo_id_modulo", "visible": 0},
            {"title": "id_poder","data": "id_poder", "visible": 0},
            {"title": "id_nivel","data": "id_nivel", "visible": 0},
            {"title": "id_plantilla_nivel","data": "id_plantilla_nivel", "visible": 0},
            {"title": "id_modulo","data": "id_modulo", "visible": 0},
        ],
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false
    });
    menuC();
}

var destruirTabla = function(){
    $('#TablaPerfilModulosPoderes').dataTable().fnClearTable();
    $('#TablaPerfilModulosPoderes').dataTable().fnDraw();
    $('#TablaPerfilModulosPoderes').dataTable().fnDestroy();
}

function agregarRol (){
    $('#formPlantillaPerfil').formValidation('validate');
};

var validarModuloPoder = function(id_modulo, arrayAgregarPoder, id_perfil){
    var oTable = $('#TablaPerfilModulosPoderes').dataTable();
    var tipo_resp = 0;
    var des_dato = '';
    if (id_modulo && arrayAgregarPoder){
        $(oTable.fnGetNodes()).each(function(i) {
            var aPos = oTable.fnGetPosition(this);
            var aData = oTable.fnGetData(aPos[0]);
            if (aData[i]['id_tipo_modulo_id_modulo'] == id_modulo && aData[i]['id_nivel'] == id_perfil){
                if (aData[i]['id_poder'] == 1){
                    tipo_resp = 1;
                }else{
                    $.each( arrayAgregarPoder, function( ii, val) {
                        if (val == aData[i]['id_poder']){
                            des_dato = aData[i]['des_poder'];
                            tipo_resp = 2;
                        };
                    });
                }
            }
        });
    };

    switch(tipo_resp) {
        case 1:
            return {valid: false,
            message: 'Verifique ya posee todos los poderes'};
        case 2:
            return {valid: false,
            message: "Verifique ya posee " + des_dato + " para este módulo"};
            break;
        default:
            return true;
    }
}

var FilMenuContextual = function(e){
    if (TablaNroSeleccionado('TablaPerfilModulosPoderes') == 0){
        $('#mm').menu('hideItem', $('#quitarseleccion')[0]);
        $('#mm').menu('hideItem', $('#del-sel')[0]);
    }else{
        $('#mm').menu('showItem', $('#quitarseleccion')[0]);
        $('#mm').menu('showItem', $('#del-sel')[0]);
    }
}

var filtrarPerfilModulos = function(id_perfil, id_tipo_modulo_id_modulo){
    var oTable = $('#TablaPerfilModulosPoderes').dataTable();
    if (id_perfil){
        oTable.fnFilter("^"+id_perfil+"$", 4, true);
    }else{
        oTable.fnFilter('', 4);
    }
    if (id_tipo_modulo_id_modulo){
        oTable.fnFilter("^"+id_tipo_modulo_id_modulo+"$", 2, true);
    }else{
        oTable.fnFilter('', 2);
    }
    if (TablaNroRegistroFil('TablaPerfilModulosPoderes') > 0 ) menuC();
}

var eliminar = function(){
    deletemodulopoder(v_id_modulos_poderes);
}

var eliminarseleccion = function(){
    deletemodulopoder(TabalRegistroSelected.join());
}

var menuC = function(){
    if (TablaNroRegistro('TablaPerfilModulosPoderes') > 0){
        $('#TablaPerfilModulosPoderes tbody tr').bind('contextmenu', function(e) {
            e.preventDefault(); //this nullifies the click
            v_id_modulos_poderes = TablaTraerCampo('TablaPerfilModulosPoderes',this).id_plantilla_nivel;
            FilMenuContextual();
            if (TablaNroRegistro('TablaPerfilModulosPoderes') > 0 ){
                $('#mm').menu('show', {
                    left: e.pageX,
                    top: e.pageY
                });
            }
        });
    }
};

$(document).ready(function(){
    actualizarDatos(datos.TablaPerfilModulosPoderes);

    $("#id_perfil").select2({
        'language': "es"
    }).on('change', function(e){
        filtrarPerfilModulos($('#id_perfil').val(), $('#id_modulo').val());
        TablaDesSelAll('TablaPerfilModulosPoderes');
        $("#id_poder").val(null).trigger("change");
    });

    $("#id_modulo").select2({
        'placeholder': "Seleccione...",
        'allowClear': true,
        'language': "es"
    }).on('change', function(e){
        filtrarPerfilModulos($('#id_perfil').val(), $('#id_modulo').val());
        if ($('#id_modulo').val()){
            procesarajax({'id_tipo_modulo_id_modulo': $('#id_modulo').val()},
            datos.filtrarpoder, 1);
        }else{
            $('#id_poder').empty();
        }
        $("#id_poder").val(null).trigger("change");
        TablaDesSelAll('TablaPerfilModulosPoderes');
    });

    $("#id_poder").select2({
        'placeholder': "Seleccione...",
        'allowClear': true,
        'language': "es"
    });

    var validar = $('#formPlantillaPerfil')
        .formValidation({
            message: 'El módulo le falta un campo para ser completado',
            fields: {
                'id_perfil': {
                    verbose: false,
                    validators: {
                        notEmpty: {
                            // message: '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;Este campo es requerido'
                            message: 'El campo es requerido'
                        }
                    }
                },
                'id_modulo': {
                    verbose: false,
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido'
                        },
                        callback: {
                            callback: function(value, validator, $field) {
                                var v_id_modulo = validator.getFieldElements('id_modulo').val();
                                var result = validator.getFieldElements('id_poder[]').val();
                                return validarModuloPoder(v_id_modulo, result, $('#id_perfil').val());
                            }
                        }
                    }
                },
                'id_poder[]': {
                    verbose: false,
                    validators: {
                        choice: {
                            min: 1,
                            // max: 3,
                            // message: 'Por favor seleccione %s, como mínimo y %s como máximo.'
                            message: 'Por favor seleccione %s, como mínimo'
                        },
                        callback: {
                            callback: function(value, validator, $field) {
                                var v_id_modulo = validator.getFieldElements('id_modulo').val();
                                var result = $field.val();
                                if (result){
                                    if (result.length > 1){
                                        if ($.inArray("1", result) > -1){
                                            return {
                                                valid: false,
                                                message: 'La opción todo debe ser única'
                                            }
                                        }
                                    }
                                }
                                return validarModuloPoder(v_id_modulo, result, $('#id_perfil').val());
                            }
                        }
                    }
                }
            }
        })
        .on('success.form.fv', function(e) {
            addmodulopoder();
        })
        .on('status.field.fv', function(e, data) {
            data.element.parents('.form-group').removeClass('has-success');
            data.fv.disableSubmitButtons(true);
    });

    $(document).on('click','#agregar',agregarRol);

    TablaSeleccionRegitro('TablaPerfilModulosPoderes', 'id_plantilla_nivel');

    var oTable = $('#TablaPerfilModulosPoderes').dataTable();
    oTable.fnFilter("^2$", 4, true);
    if (TablaNroRegistroFil('TablaPerfilModulosPoderes') > 0 ) menuC();
});