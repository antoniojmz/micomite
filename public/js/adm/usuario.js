var v_id_usuario_acceso, v_id_perfil, v_id_acceso = var_tribunal=0;

var var_p = '';

var mostrardatos = function(response){
    if (response.usuario[0].urlimage!=null){
        if (response.usuario[0].urlimage.length>1){
            $('.foto-perfil').attr('src',response.usuario[0].urlimage)+ '?' + Math.random();
        }
    }
    $('#nombre').val(response.usuario[0].name);
    $('#id_usuario').val(response.usuario[0].user_id);
    // $('#activo').val(response.usuario[0].activo);
    $("#activo").prop( "checked", response.usuario[0].activo);
    // $("#activo").is(':checked') ? 1 : 0;
    destruirTabla('TablaPerfil');
    // console.log('pase por aqui');
    actualizarDatos(response.TablaUsuarioPerfil);
}

var procesarajax = function(data, ruta, caso){
    // console.log(data);
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
            case 3:
                mensajesAlerta('Procesado!','Se procesó con éxito.', 'info');
                break;
            case 2:
            case 4:
                mensajesAlerta('Procesado!','Se procesó con éxito.', 'info');
                mostrardatos(response);
                break;
            case 5:
                $('#id_poder').select2({
                    'placeholder': "Seleccione...",
                    'language': "es",
                    'width': '100%',
                });
                destruirTabla('TablaAcceso');
                TablaAccesos(response.acceso);
                $("#id_modulo").select2({
                    'placeholder': "Seleccione...",
                    'language': "es",
                    'allowClear': true,
                    'width': '100%',
                    'data': response.moduloscombo,
                }).on('change', function(e){
                    var oTable = $('#TablaAcceso').dataTable();
                    if ($('#id_modulo').val()){
                        procesarajax({'id_tipo_modulo_id_modulo': $("#id_modulo").val()}, datos.rutafiltrarpoder, 6);
                        oTable.fnFilter("^"+ $("#id_modulo").val() +"$", 3, true);
                    }else{
                        $('#id_poder').empty();
                        oTable.fnFilter('', 3,true);
                    }
                    $("#id_poder").val(null).trigger("change");
                });
                break;
            case 6:
                    $('#id_poder').empty();
                    $('#id_poder').select2({
                        'placeholder': "Seleccione...",
                        'data': response,
                        'language': "es"
                    });
                break;
            case 7:
                destruirTabla('TablaAcceso');
                TablaAccesos(response);
                $(".combo").val(null).trigger("change");
                mensajesAlerta('Procesado!','Se procesó con éxito.', 'info');
                break;
            default:
                mostrardatos(response);
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
};

var TablaAccesos = function (obj_datos){
    $("#TablaAcceso").dataTable({
        aLengthMenu: [[4, 10, -1],[4, 10, "All"]],
        language: lenguajeTabla,
        data: obj_datos,
        columns:[
            {"title": "Módulo","data": "des_cod_modulo"},
            {"title": "Poder","data": "des_poder"},
            {"title": "id_acceso","data": "id_acceso", "visible":0},
            {"title": "id_tipo_modulo_id_modulo","data": "id_tipo_modulo_id_modulo", "visible":0},
            {"title": "id_poder","data": "id_poder", "visible":0}
        ],
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false
    });
    menuC('TablaAcceso');
}

var actualizarDatos = function (obj_datos){
    // console.log(obj_datos);
    $("#TablaPerfil").dataTable({
        aLengthMenu: [[4, 10, -1],[4, 10, "All"]],
        language: lenguajeTabla,
        data: obj_datos,
        columns:[
            {"title": "Sede","data": "des_sede"},
            {"title": "Perfil","data": "des_nivel"},
            {"title": "Estado","data": "des_estado"},
            {"title": "Estatus","data": "activo_usuario_acceso"},
            {"title": "id_usuario_acceso","data": "id_usuario_acceso", "visible":0},
            {"title": "id_sede","data": "id_sede", "visible":0},
            {"title": "id_nivel","data": "id_nivel", "visible":0},
        ],
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false,
        fnCreatedRow: function(elemt, data, index){
            if (data.activo_usuario_acceso){
                $('td:eq(3)', elemt).html('Activo');
            }else{
                $('td:eq(3)', elemt).html('Inactivo');
            }
        },
    });
    menuC('TablaPerfil');
}

var buscarusuario = function(rut){
    procesarajax({'rut':rut}, datos.rutabuscarusuario, 1);
};

var destruirTabla = function(tabla){
    if ($('#'+tabla).dataTable()){
        $('#'+tabla).dataTable().fnClearTable();
        $('#'+tabla).dataTable().fnDraw();
        $('#'+tabla).dataTable().fnDestroy();
    }
}

var limpiar = function(){
    $('.foto-perfil').attr('src','/img/foto.png')+ '?' + Math.random();
    destruirTabla('TablaPerfil');
    actualizarDatos(null);
    $(".sel").val(null).trigger("change");
    $('#nombre').val('');
    $("#activo").prop("checked", false);
    $('#id_usuario').val('');
    $("#rut").off("keypress");
}

var menuC = function(tabla){
    if (TablaNroRegistro(tabla) > 0){
        $('#'+ tabla +' tbody tr').bind('contextmenu', function(e) {
            e.preventDefault(); //this nullifies the click
            var v_row = TablaTraerCampo(tabla,this);
            FilMenuContextual(v_row, tabla);
            if (tabla == 'TablaPerfil'){
                v_id_usuario_acceso = v_row.id_usuario_acceso;
                v_id_perfil = v_row.id_nivel;
            }else{
                v_id_acceso = v_row.id_acceso;
            }
            if (TablaNroRegistro(tabla) > 0 ){
                $('#mm').menu('show', {
                    left: e.pageX,
                    top: e.pageY
                });
            }
        });
    }
};

var FilMenuContextual = function(row, tabla){
    if (tabla == 'TablaPerfil'){
        $('#mm').menu('hideItem', $('#del_acceso')[0]);
        $('#mm').menu('showItem', $('#M_AccesoAvanzado')[0]);
        $('#mm').menu('showItem', $('#Act_Plantilla')[0]);

        if(row.activo_usuario_acceso){
            $('#mm').menu('hideItem', $('#p_activo')[0]);
            $('#mm').menu('showItem', $('#p_inactivo')[0]);
        }else{
            $('#mm').menu('showItem', $('#p_activo')[0]);
            $('#mm').menu('hideItem', $('#p_inactivo')[0]);
        }
    }else{
        $('#mm').menu('showItem', $('#del_acceso')[0]);
        $('#mm').menu('hideItem', $('#M_AccesoAvanzado')[0]);
        $('#mm').menu('hideItem', $('#Act_Plantilla')[0]);
        $('#mm').menu('hideItem', $('#p_activo')[0]);
        $('#mm').menu('hideItem', $('#p_inactivo')[0]);
    }
}

function agregarRol (){
    $('#formusuario').formValidation('validate');
};

var Procesoactivo = function(){
    if ($('#id_usuario').val()){
        $.messager.confirm('Confirmación', 'Seguro desea ' + (($("#activo").prop('checked'))?'activar':'desactivar') +  ' este usuario' , function(r){
            if (r){
                procesarajax({'id_usuario': $("#id_usuario").val(), 'estatus': $("#activo").prop('checked')}, datos.rutaestatususuario, 2);
            }else{
                $("#activo").prop("checked", (!$("#activo").prop('checked')));
            }
        });
    }
}

var EstatusPerfil = function(estatusperfil){
    procesarajax({'id_usuario_acceso': v_id_usuario_acceso, 'estatus': estatusperfil, 'id_usuario': $("#id_usuario").val()}, datos.rutaestatuusuarioperfil, 2);
}

var validarUsuarioPerfil = function(id_sede, id_perfil, id_tribunal){
    var oTable = $('#TablaPerfil').dataTable();
    var tipo_resp = 0;
    if (id_sede && id_perfil && id_tribunal){
        $(oTable.fnGetNodes()).each(function(i) {
            var aPos = oTable.fnGetPosition(this);
            var aData = oTable.fnGetData(aPos[0]);
            if (aData[i]['id_sede'] == id_sede && aData[i]['id_nivel'] == id_perfil){
                tipo_resp = 1;
            }
        });
    };
    switch(tipo_resp) {
        case 1:
            return {valid: false,
            message: 'Verifique; ya posee el perfil es esa sede'};
        default:
            return true;
    }
}

var ActualizarPlantilla = function(){
    $.messager.confirm('Confirmación', 'Seguro desea desea actualizar con la plantilla' , function(r){
        if (r){
            procesarajax({'id_usuario_acceso': v_id_usuario_acceso, 'id_perfil': v_id_perfil}, datos.rutaactualizarplantilla, 3);
        };
    });
}

var formAccesoAvanzado = function(){
    procesarajax({'id_usuario_acceso': v_id_usuario_acceso}, datos.rutaaccesoavanzado, 5);
    $('#w').window('open');
    AjustarTabla('TablaAcceso');
    $("#id_modulo").val(null).trigger("change");
    $("#id_poder").val(null).trigger("change");
}

var AgregarAcceso = function(){
    $('#formmodulospoderes').formValidation('validate');
}

var DelAcceso = function(){
    procesarajax({'id_acceso': v_id_acceso, 'id_usuario_acceso': v_id_usuario_acceso}, datos.rutaEliminarAcceso, 7);
}
var consultarUsuario = function(){
    $('#formbuscarsuario').formValidation('validate');
}
$(document).ready(function(){
    actualizarDatos(null);
    $("#id_sede").select2({
        placeholder: "Seleccione Sede",
        allowClear: true,
        // minimumResultsForSearch: -1,
    }).on('change', function(e){
        $('#txtSedeCombo').val(($('#id_sede').val().length > 0) ? $('#id_sede').val():0);
    });

    $("#id_perfil").select2({
        placeholder: "Seleccione Perfil",
        allowClear: true,
    }).on('change', function(e){
        $('#txtPerfilCombo').val(($('#id_perfil').val().length > 0) ? $('#id_perfil').val():0);
    });

    var validar = $('#formbuscarsuario').formValidation({
            message: 'El módulo le falta un campo para ser completado',
            fields: {
                'rut': {
                    verbose: false,
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido'
                        },
                        // digits: {
                        //     message: 'Debe ingresar sólo números'
                        // },
                        stringLength: {
                            min: 3,
                            message: 'El rut debe tener más de 3 caracteres.'
                        },
                    }
                }
            }
        })
        .on('success.form.fv', function(e) {
            buscarusuario($('#rut').val());
            $('#rut').on('keypress',function(e){
                limpiar();
            });
        })
        .on('status.field.fv', function(e, data) {
            data.element.parents('.form-group').removeClass('has-success');
            data.fv.disableSubmitButtons(true);
    });
    var validar3 = $('#formmodulospoderes')
        .formValidation({
            message: 'Debe seleccionar',
            fields: {
                'id_modulo': {
                    verbose: false,
                    validators: {
                        notEmpty: {
                            message: "El campo es requerido"
                        },
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
                                return validarModuloPoder(v_id_modulo, result);
                            }
                        }
                    }
                }
            }
        })
        .on('success.form.fv', function(e) {
            procesarajax(
                {   'id_usuario_acceso': v_id_usuario_acceso,
                    'id_tipo_modulo_id_modulo': $('#id_modulo').val(),
                    'id_poder': $('#id_poder').val(),
                },
                datos.rutaAgregarAcceso, 7
            );
        })
        .on('status.field.fv', function(e, data) {
            data.element.parents('.form-group').removeClass('has-success');
            data.fv.disableSubmitButtons(true);
    });
    var validar3 = $('#formusuario').formValidation({
            excluded: [':disabled'],
            message: 'Debe buscar un usuario',
            fields: {
                'id_sede': {
                    verbose: false,
                    validators: {
                        notEmpty: {
                            message: "El campo es requerido"
                        },
                        callback: {
                            callback: function(value, validator, $field) {
                                // var v_id_usuario = $('#id_usuario').val();
                                if ($('#id_usuario').val().length == 0){
                                    $("#id_sede").val(null).trigger("change");
                                    return {valid: false,
                                        message: 'Verifique debe seleccionar un usuario.'};
                                }
                                // return true;
                                return validarUsuarioPerfil($('#id_sede').val(), $('#id_perfil').val(), $('#id_tribunal').val());
                            }
                        }
                    }
                },
                'id_perfil': {
                    verbose: false,
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido'
                        },
                        callback: {
                            callback: function(value, validator, $field) {
                                // var v_id_usuario = $('#id_usuario').val();
                                if ($('#id_usuario').val().length == 0){
                                    $("#id_perfil").val(null).trigger("change");
                                    return {valid: false,
                                        message: 'Verifique debe seleccionar un usuario.'};
                                }
                                // return true;
                                return validarUsuarioPerfil($('#id_sede').val(), $('#id_perfil').val(), $('#id_tribunal').val());
                            }
                        }
                    }
                },
            }
        })
        .on('success.form.fv', function(e) {
            procesarajax(
                {   'id_usuario': $('#id_usuario').val(),
                    'id_sede': $('#id_sede').val(),
                    'id_perfil': $('#id_perfil').val(),
                },
                datos.rutaasignarperfil, 4);
        })
        .on('status.field.fv', function(e, data) {
            data.element.parents('.form-group').removeClass('has-success');
            data.fv.disableSubmitButtons(true);
    });
    var validarModuloPoder = function(id_modulo, arrayAgregarPoder){
        var oTable = $('#TablaAcceso').dataTable();
        var tipo_resp = 0;
        var des_dato = '';
        if (id_modulo && arrayAgregarPoder){
            $(oTable.fnGetNodes()).each(function(i) {
                var aPos = oTable.fnGetPosition(this);
                var aData = oTable.fnGetData(aPos[0]);
                if (aData[i]['id_tipo_modulo_id_modulo'] == id_modulo){
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
        switch(tipo_resp){
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
    TablaSeleccionRegitro('TablaPerfil', 'id_usuario_acceso');
    $(document).on('click','#agregar',agregarRol);
    $(document).on('click','#AgregarAcceso',AgregarAcceso);
    $(document).on('click','#consultar',consultarUsuario);
    TablaAccesos([]);
});