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
            case 2:
                destruirTabla();
                mensajesAlerta('Procesado!','Se eliminó con éxito.', 'info');
                break;
            case 3:
                destruirTabla();
                mensajesAlerta('Procesado!','Se registró con éxito.', 'info');
                break;
        }
        actualizarDatos(response);
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

var mostrardatos = function(rel_id_modulo){
    procesarajax({'rel_id_modulo':rel_id_modulo}, datos.rutalistar, 1);
};

var deletemodulopoder = function (id_tipo_modulo_poder){
    $.messager.confirm('Confirmación', 'Seguro desea eliminar ' + id_tipo_modulo_poder.toString().split(",").length, function(r){
        if (r){
            procesarajax({'id_tipo_modulo_poder':id_tipo_modulo_poder}, datos.rutadeletemodulopoder, 2);
            var oTable = $('#tablaModulospoderes').dataTable();
            oTable.fnFilter("^"+$('#id_modulo').val()+"$", 2, true);
            $("#id_poder").val(null).trigger("change");
            if (TablaNroRegistroFil('tablaModulospoderes') > 0 ) menuC();
        }
    });
}

var addmodulopoder = function(){
    procesarajax(
            {'poderes': $('#id_poder').val(), 'id_tipo_modulo_id_modulo' : $("#id_modulo").val()},
            datos.rutaaddmodulopoder, 3);
    $("#id_poder").val(null).trigger("change");
    if ($('#id_modulo').val()){
        var oTable = $('#tablaModulospoderes').dataTable();
        oTable.fnFilter("^"+$('#id_modulo').val()+"$", 2, true);
    }
    $("#id_poder").val(null).trigger("change");
    menuC();
}

var actualizarDatos = function (obj_datos){
    $("#tablaModulospoderes").dataTable({
        aLengthMenu: [[4, 10, -1],[4, 10, "All"]],
        language: lenguajeTabla,
        data: obj_datos,
        columns:[
            {"title": "Módulo","data": "des_cod_modulo"},
            {"title": "Poder","data": "des_poder"},
            {"title": "id_tipo_modulo_id_modulo","data": "id_tipo_modulo_id_modulo", "visible": 0},
            {"title": "id_modulos_poderes","data": "id_modulos_poderes", "visible": 0},
        ],
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false
    });
    menuC();
}

var destruirTabla = function(){
    $('#tablaModulospoderes').dataTable().fnClearTable();
    $('#tablaModulospoderes').dataTable().fnDraw();
    $('#tablaModulospoderes').dataTable().fnDestroy();
}

var agregarRol = function (){
    $('#formmodulospoderes').formValidation('validate');
};

var validarModuloPoder = function(id_modulo, arrayAgregarPoder){
    if (TablaNroRegistro('tablaModulospoderes') > 0 ){
        var oTable = $('#tablaModulospoderes').dataTable();
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
}

var FilMenuContextual = function(e){
    if (TablaNroSeleccionado('tablaModulospoderes') == 0){
        $('#mm').menu('hideItem', $('#quitarseleccion')[0]);
        $('#mm').menu('hideItem', $('#del-sel')[0]);
    }else{
        $('#mm').menu('showItem', $('#quitarseleccion')[0]);
        $('#mm').menu('showItem', $('#del-sel')[0]);
    }
}

var eliminar = function(){
    deletemodulopoder(v_id_modulos_poderes);
}

var eliminarseleccion = function(){
    deletemodulopoder(TabalRegistroSelected.join());
}

var menuC = function(){
    if (TablaNroRegistro('tablaModulospoderes') > 0){
        $('#tablaModulospoderes tbody tr').bind('contextmenu', function(e) {
            e.preventDefault(); //this nullifies the click
            v_id_modulos_poderes = TablaTraerCampo('tablaModulospoderes',this).id_modulos_poderes;
            FilMenuContextual();
            if (TablaNroRegistro('tablaModulospoderes') > 0 ){
                $('#mm').menu('show', {
                    left: e.pageX,
                    top: e.pageY
                });
            }
        });
    }
};

$(document).ready(function(){
    TabalRegistroSelected = [];
    actualizarDatos(datos.TablaModulosPoderes);

    var validar = $('#formmodulospoderes')
        .formValidation({
            message: 'El módulo le falta un campo para ser completado',
            fields: {
                'id_modulo': {
                    verbose: false,
                    validators: {
                        notEmpty: {
                            // message: '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;Este campo es requerido'
                            message: 'El campo es requerido'
                        },
                        callback: {
                            callback: function(value, validator, $field) {
                                var v_id_modulo = validator.getFieldElements('id_modulo').val();
                                var result = validator.getFieldElements('id_poder[]').val();
                                return validarModuloPoder(v_id_modulo, result);
                            }
                        }
                    }
                },
                'id_poder[]': {
                    // selector: '.percent',
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
                                return validarModuloPoder(v_id_modulo, result);
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

    $("#id_modulo").select2({
        'placeholder': "Seleccione...",
        'allowClear': true,
    }).on('change', function(e){
        var oTable = $('#tablaModulospoderes').dataTable();
        if ($('#id_modulo').val()){
            oTable.fnFilter("^"+$('#id_modulo').val()+"$", 2, true);
        }else{
            oTable.fnFilter('', '2');
        }
        TabalRegistroSelected = [];
        $("#id_poder").val(null).trigger("change");
        if (TablaNroRegistroFil('tablaModulospoderes') > 0 ) menuC();
    });

    $("#id_poder").select2({
        'placeholder': "Seleccione...",
        'allowClear': true,
    });

    $(document).on('click','#agregar',agregarRol);

    TablaSeleccionRegitro('tablaModulospoderes', 'id_modulos_poderes');
    menuC();
});