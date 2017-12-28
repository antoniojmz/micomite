var RegistroPago=RegistroPagoPropietario='';
var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
}; 

function formatoCentimos(n) {
    var cadena =  n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    cadena = cadena.replace(',','.');
    signo = '$';
  return signo.concat(cadena);
};
function formatoPorcentaje(n) {
    var cadena =  n.concat('%');
  return cadena;
};

var cargarTablaPagos = function(data){
    $("#tablaPagos").dataTable({
        "paging":  false,
        "ordering": false,
        "info":     false,
        "searching": false,
        "data": data, 
        "columns":[
        {"title": "Facturación","data": "mes_inicio"},
        {"title": "Dpto.","data": "numero"},
        {"title": "Monto del Gasto Comun","data": "monto_gcomun_apto", 
         "render" : function( data, type, full ) { return formatoCentimos(data);}},
        {"title": "Monto Fondo de Reserva","data": "monto_fondo_reserva", 
          "render" : function( data, type, full ) { return formatoCentimos(data); }},
        {"title": "Monto Adicionales","data": "mes_pago_adicional", 
         "render" : function( data, type, full ) { return formatoCentimos(data); }},
        {"title": "Monto Total de la Deuda","data": "monto_total_deudas", 
        "render" : function( data, type, full ) { return formatoCentimos(data); }},
        {"title": "Monto Abonado","data": "monto_total_abonado", 
        "render" : function( data, type, full ) { return formatoCentimos(data); }},
        {"title": "Saldo Deudor","data": "saldo_deudor", 
        "render" : function( data, type, full ) { return formatoCentimos(data); }},
        {"title": "Saldo a Favor","data": "saldo_a_favor", 
        "render" : function( data, type, full ) { return formatoCentimos(data); }},
        {"title": "Debe","data": "deuda", 
        "render" : function( data, type, full ) { return formatoCentimos(data); }},
        {"title": "id_apartamento","data": "id_apartamento", visible:0},
        {"title": "id_periodo","data": "id_periodo", visible:0}
        ],
            "fnCreatedRow": function(row,data,dataIndex){
                if (data.deuda!=0){
                    $(row).css("color","#B40404");
            }
        }
    });
};

var cargarTablaPagosResumen = function(data){
    $("#tablaPagosResumen").dataTable({
        "paging":  false,
        "ordering": false,
        "info":     false,
        "searching": false,
        "data": data,
        "columns":[
        {"title": "Facturación","data": "mes_inicio"},
        {"title": "Fecha Inicio","data": "fecha_inicio"},
        {"title": "Fecha Corte","data": "fecha_corte"},
        {"title": "Nro. Dpto","data": "numero"},
        {"title": "% Prorretaje","data": "prorretaje",
       "render" : function( data, type, full ) { return formatoPorcentaje(data); }},
        {"title": "Monto de su Deuda","data": "deuda", 
        "render" : function( data, type, full ) { return formatoCentimos(data); }},
        {"title": "id_apartamento","data": "id_apartamento", visible:0},
        {"title": "id_periodo","data": "id_periodo", visible:0}
        ],  "fnCreatedRow": function(row,data,dataIndex){
            if (data.deuda!=0){
                $(row).css("color","#B40404");
            }
        }
    });
};

var cargarTablaPagosPropietario = function(data){
    $("#tablaPagosPropietarios").dataTable({
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
        {"title": "Id","data": "id_pago_propietario",visible:0},
        {"title": "Fecha Facturación","data": "fecha_inicio"},
        {"title": "Mes Facturación","data": "mes_inicio"},
        {"title": "Nro. Dpto","data": "numero"},
        {"title": "Monto Deuda","data": "monto_deuda", 
        "render" : function( data, type, full ) { return formatoCentimos(data); }},
        {"title": "Monto Pagado","data": "monto", 
        "render" : function( data, type, full ) { return formatoCentimos(data); }},
        {"title": "Fecha de Pago","data": "fecha_pago"},
        {"title": "Código de Verificación","data": "codigo_verificacion"},
        {"title": "Estatus del Pago","data": "estatus_pago"}
        ],
         "fnCreatedRow": function(row,data,dataIndex){
            if (data.estatus=='R'){
                $(row).css('color','#DF0101');
            }
             if (data.estatus=='A'){
                $(row).css('color','#FF8000');
            }
             if (data.estatus=='C'){
                $(row).css('color','#088A08');
            }
        },
    });

};


var mostrarPago = function(){
    $(".divForm").toggle();
};
var volverTabla = function(){
    $(".divForm").toggle();
    $('#foto-pagos').attr('src','/img/pagos.svg')+ '?' + Math.random();
    $('#FormPagos')[0].reset();
};
var cargarFormularioPago= function(){
    $(".caja-pago").show();
    $(".divForm").toggle();
}

var volverTabla = function(){
    $(".divForm").toggle();
    $('#foto-pagos').attr('src','/img/pagos.svg')+ '?' + Math.random();
    $('#FormPagos')[0].reset();
};
// var cargarFormularioPago= function(data){
//     $("#divRegistroPago").window('open');
//     if(data.id_apartamento!=null){$(".id_apto").val(data.id_apartamento);}
//     if(data.id_periodo!=null){$(".id_periodo").val(data.id_periodo);}
//     $("#numero_apto").text(data.propietario + ", Apartamento # " + data.numero);

// }
var ProcesarPago= function(data){
    var form = $('#FormPagos').get(0);
    var formData = new FormData(form);
    parametroAjax.data = formData;
    parametroAjax.ruta=ruta;
    respuesta=procesarajaxfile(parametroAjax);
    ManejoRespuestaProcesar(respuesta);
}
var ManejoRespuestaProcesar= function(data){

    if (respuesta.code=='200'){
        var res = JSON.parse(respuesta.respuesta.f_registro_pagos);
        switch(res.code) {
            case '200':
                mensajesAlerta('Procesado!',res.des_code, 'info');
                limpiarTablaPagosPropietarios();
                cargarTablaPagosPropietario(respuesta.respuesta.v_pagos_propietarios);
                limpiarTablaPagosResumen();
                cargarTablaPagosResumen(respuesta.respuesta.v_pagos_resumen);
                crearallcombos();
                limpiarTablaPagos();
                cargarTablaPagos(d.v_pagos);

                $("#id_pago_propietario").val(res.id_pago_propietario);
                $('#foto-pagos').attr('src',respuesta.respuesta.rutadelaimagen)+ '?' + Math.random();
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
}
var crearallcombos = function(data){
    crearcombo('#id_tipo_pago','');
}
var cargarConsultaPagos = function(){
    $('.divTabla').hide();
    $('.divForm').hide();
    $('.divConsultaPagos').show();
    $(".boton1").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
    $(".boton2").removeClass( "botonNoSeleccion" ).addClass("botonSeleccion");
}
var cargarPagosPendientes = function(){
    $('#divTabla').show();
    $('#divForm').hide();
    $('.divConsultaPagos').hide();
    $(".boton1").removeClass( "botonNoSeleccion" ).addClass("botonSeleccion");
    $(".boton2").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
}
var imprimirComprobante = function(){
   OpenWindowWithPost('/reportes/comprobante_de_pago.php','_blank','f',RegistroPagoPropietario);
}
var pagarDeuda = function(){
 
     if(d.v_pagos_resumen[0].deuda == 0 || d.v_pagos_resumen[0].deuda == null  ){
        mensajesAlerta('Error','No posee deuda en el mes', 'error');
     }else{
        cargarFormularioPago();
        if(d.v_pagos_resumen[0].id_apartamento!=null){$(".id_apto").val(d.v_pagos_resumen[0].id_apartamento);}
        if(d.v_pagos_resumen[0].id_periodo!=null){$(".id_periodo").val(d.v_pagos_resumen[0].id_periodo);}
        $("#numero_apto").text(d.v_pagos_resumen[0].propietario + ", Apartamento # " + d.v_pagos_resumen[0].numero);
     }

}

var mostrarCal = function (){$("#fecha_pago").focus();};
var validarP=function(){$('#FormPagos').formValidation('validate');};
var limpiarTablaPagosPropietarios = function(){destruirTablaS('tablaPagosPropietarios');};
var limpiarTablaPagosResumen = function(){destruirTablaS('tablaPagosResumen');};
var limpiarTablaPagos = function(){destruirTablaS('tablaPagos');};

$(document).ready(function(){
    $("#spanTitulo").text("Resumen de Facturación");
    // formatos
    // $('.moneda').priceFormat({
    //     prefix:'',
    //     centsSeparator:',',
    //     thousandsSeparator:'.'
    // });
    $('.moneda').priceFormat({
        prefix:'',
        thousandsSeparator: '.',
        centsLimit: 0
    });


    var fecha_n = $('#fecha_pago').datetimepicker();
    $(document).on('click','#divConsultaPagos',cargarConsultaPagos);
    $(document).on('click','#divPagosPendientes',cargarPagosPendientes);
    $(document).on('click','.cal',mostrarCal);
    $(document).on('click','#agregar',mostrarPago);
    $(document).on('click','#cancelar',volverTabla);
    $(document).on('click','#guardar',validarP);
    $(document).on('click','#pagarDeuda',pagarDeuda);


    cargarTablaPagosPropietario(d.v_pagos_propietarios);

    cargarTablaPagosResumen(d.v_pagos_resumen);
    crearallcombos();
    cargarTablaPagos(d.v_pagos);

    $(".boton1").addClass( "botonSeleccion" );
    $(".boton2").addClass( "botonNoSeleccion" );

    $('id_periodo').val(d.v_pagos_resumen[0].id_periodo);
    $('deuda').val(d.v_pagos_resumen[0].deuda);
    $('id_apartamento').val(d.v_pagos_resumen[0].id_apartamento);

    var tableA = $('#tablaPagosPropietarios').dataTable();
    $('#tablaPagosPropietarios tbody').on('click', 'tr', function (e) {
        tableA.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroPagoPropietario = TablaTraerCampo('tablaPagosPropietarios',this);
        imprimirComprobante(RegistroPagoPropietario);
    });
    tableA.on('dblclick', 'tr', function () {
        $('#close').trigger('click');
    });

    //  $(function() {
    //     $.contextMenu({
    //         selector: '#tablaPagosPropietarios',
    //         callback: function(key, options) {
    //             switch(key) {
    //                 case "1":
    //                     // COMPROBANTE DE PAGO
    //                     imprimirComprobante(RegistroPagoPropietario);

    //                 break;
    //             }
    //         },
    //         items: {
    //             "1": {name: "Imprimir", icon: "edit"},
    //         }
    //     });
    // });


    // var tableB = $('#tablaPagosResumen').dataTable();
    // $('#tablaPagosResumen tbody').on('click', 'tr', function (e) {
    //     tableB.$('tr.selected').removeClass('selected');
    //     $(this).addClass('selected');
    //     RegistroPago = TablaTraerCampo('tablaPagosResumen',this);

    // });
    // tableB.on('dblclick', 'tr', function () {
    //     $('#close').trigger('click');
    // });

    //  $(function() {
    //     $.contextMenu({
    //         selector: '#tablaPagosResumen',
    //         callback: function(key, options) {
    //             switch(key) {
    //                 case "1":
    //                     if(RegistroPago.deuda == 0){
    //                         mensajesAlerta('Error','Debe seleccionar el ultimo mes de su Facturación', 'error');
    //                     }else{
    //                         cargarFormularioPago();
    //                         if(RegistroPago.id_apartamento!=null){$(".id_apto").val(RegistroPago.id_apartamento);}
    //                         if(RegistroPago.id_periodo!=null){$(".id_periodo").val(RegistroPago.id_periodo);}
    //                         $("#numero_apto").text(RegistroPago.propietario + ", Apartamento # " + RegistroPago.numero);
    //                     }

    //                 break;
    //             }
    //         },
    //         items: {
    //             "1": {name: "Pagar", icon: "edit"},
    //         }
    //     });
    // });

    $('#FormPagos').formValidation({
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'id_tipo_pago': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'codigo_verificacion': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'fecha_pago': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'monto': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'foto': {
                validators: {
                    notEmpty: {
                        message: 'Por favor, cargue la imagen del comprobante de pago.'
                    },
                    file: {
                        extension: 'jpeg,jpg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 2097152,   // 2048 * 1024
                        message: 'El archivo cargado no es válido'
                    }
                }
            }
        }
    }).on('success.form.fv', function(e){
        ProcesarPago();
    }).on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });

});