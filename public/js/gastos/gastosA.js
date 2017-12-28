var combos=id_tipo_padre=id_tipo_gastoP=caso=id_periodo = 0;
var Registrogasto = Registrogastoadicional =  RegistroPagoPropietario = TotalesMes = '' ;
var v_totales_mes = v_gastos = v_gastos_adicionales = v_calculo_gcomunes= '';
var mes = []; mes[0] = '' ; mes[1] = 'ENERO'; mes[2]='FEBRERO'; mes[3]='MAYO'; mes[4] = 'ABRIL'; mes[5]='MAYO'; mes[6] = 'JUNIO'; mes[7]='JULIO'; mes[8]='AGOSTO'; mes[9]='SEPTIEMBRE'; mes[10]='OCTUBRE'; mes[11]='NOVIEMBRE'; mes[12]='DICIEMBRE';
var RegistroApartamento='';
var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var cargarTablaGastos = function(data){
    $("#tablaGastos").dataTable({
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
        {"title": "Id","data": "id_pago_gcomun",visible:0},
        {"title": "Tipo de Gasto","data": "tipo_gasto"},
        {"title": "Concepto","data": "concepto_detalle"},
        {"title": "Fecha Factura","data": "fecha_factura"},
        {"title": "Monto","data": "monto",
        "render" : function( data, type, full ) { return formatoCentimos(data); }
        },
        {"title": "Archivo","data": "urlimage", visible:0},
        {"title": "Sede","data": "id_sede",visible:0},
        {"title": "Fecha de Carga","data": "fecha_carga",visible:0}
        ],
    });
};
var cargarTablaGastosConsulta  = function(data){
    $("#tablaResumenGastosMes").DataTable({
    "paging":  false,
    "ordering": false,
    "info":     false,
    "searching": false,
    "searchable":false,
    "data": data,
    "language": {
            "url": "/DataTables-1.10.10/de_DE-all.txt"
        },
    "columns":[
        {"title": "Id","data": "id_pago_gcomun",visible:0},
        {"title": "Concepto","data": "concepto_detalle"},
        {"title": "Fecha Factura","data": "fecha_factura", "width":"10%"},
        {"title": "Monto","data": "monto",
        "render" : function( data, type, full ) { return formatoCentimos(data); }
        },
        {"title": "Archivo","data": "urlimage", visible:0},
        {"title": "Sede","data": "id_sede",visible:0},
        {"title": "Fecha de Carga","data": "fecha_carga",  "width":"10%"}
        ]
    });
};
var imprimirGasto = function(){
    var parametros = { v_totales_mes:v_totales_mes, v_gastos:v_gastos, v_gastos_adicionales:v_gastos_adicionales, v_calculo_gcomunes:v_calculo_gcomunes };
    OpenWindowWithPost('/reportes/reporte_gastos_comunes.php','_blank','f',parametros);
}
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
        {"title": "Propietario","data": "propietario"},
        {"title": "Monto Deuda","data": "monto_deuda", 
         "render" : function( data, type, full ) { return formatoCentimos(data); }},
        {"title": "Monto Pagado","data": "monto", 
         "render" : function( data, type, full ) { return formatoCentimos(data); }},
        {"title": "Fecha de Pago","data": "fecha_pago"},
        {"title": "Código de Verificación","data": "codigo_verificacion"}
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

var cargarTablaGastosComunes = function(data){
    var table = $("#tablaGastosComunes").DataTable({
    "paging":  false,
    "ordering": false,
    "info":     false,
    "searching": false,
    "searchable":false,
    "data": data,
    "language": {
            "url": "/DataTables-1.10.10/de_DE-all.txt"
        },
    "columns":[
    {"title": "Id","data": "id_pago_gcomun",visible:0},
    {"title": "Tipo de Gasto","data": "tipo_gasto"},
    {"title": "Concepto","data": "concepto_detalle"},
    {"title": "Fecha Factura","data": "fecha_factura"},
    {"title": "Monto","data": "monto", 
     "render" : function( data, type, full ) { return formatoCentimos(data); }},
    {"title": "Sede","data": "id_sede",visible:0},
    {"title": "Fecha de Carga","data": "fecha_carga",visible:0}]
    });
};


var cargarTablaCalculoGcomunes = function(data){
     $("#tablaCalculoGcomunes").dataTable({
        "paging":  false,
        "ordering": false,
        "info":     false,
        "searching": false,
        "data": data,
         "language": {
            "url": "/DataTables-1.10.10/de_DE-all.txt"
        },
        "columns":[
        {"title": "Nro. Apto","data": "numero"},
        {"title": "Propietario","data": "propietario"},
        {"title": "Prorretaje %","data": "prorretaje"},
        {"title": "Monto Gastos Comunes","data": "monto_gcomunes", 
         "render" : function( data, type, full ) { return formatoCentimos(data); }},
        {"title": "Monto Fondo de Reserva","data": "valor_gasto_reserva", 
        "render" : function( data, type, full ) { return formatoCentimos(data); }},
        {"title": "Monto Adicionales","data": "monto_adicional", 
         "render" : function( data, type, full ) { return formatoCentimos(data); }},
        {"title": "Monto Total","data": "monto_total_deuda",
         "render" : function( data, type, full ) { return formatoCentimos(data); }},
        {"title": "Saldo a Favor","data": null},
        {"title": "Saldo Deudor","data": null}
        ]});
};

var cargarTablaGastosAdicionales = function(data){
    $("#tablaGastosAdicionales").dataTable({
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
            {"title": "Id","data": "id_pago_adicional",visible:0},
            {"title": "Tipo de Gasto","data": "tipo_gasto"},
            {"title": "Concepto","data": "concepto_detalle"},
            {"title": "Propietario","data": "propietario"},
            {"title": "Fecha Carga","data": "fecha_carga"},
            {"title": "Monto","data": "monto",
            "render" : function( data, type, full ) { return formatoCentimos(data); }
            },
            {"title": "Descripcion","data": "descripcion"},
            {"title": "Sede","data": "id_sede",visible:0}
        ],
    });
};
var cargarTablaGastosAdicionalesConsulta = function(data){
    $("#tablaGastosAdicionalesConsulta").dataTable({
        "paging":  false,
        "ordering": false,
        "info":     false,
        "searching": false,
        "searchable":false,
        "data": data,
         "language": {
            "url": "/DataTables-1.10.10/de_DE-all.txt"
        },
        "columns":[
            {"title": "Id","data": "id_pago_adicional",visible:0},
            {"title": "Concepto","data": "concepto_detalle"},
            {"title": "Propietario","data": "propietario"},
            {"title": "Fecha Carga","data": "fecha_carga"},
            {"title": "Monto","data": "monto",
            "render" : function( data, type, full ) { return formatoCentimos(data); }
            },
            {"title": "Descripcion","data": "descripcion"},
            {"title": "Sede","data": "id_sede",visible:0}
        ],
    });
};

var cargarTablaConsultaGastos = function(data){
    $("#tablaConsultaGastos").dataTable({
        "paging":  false,
        "ordering": false,
        "info":     false,
        "searching": false,
        "data": data,
        "language": {
            "url": "/DataTables-1.10.10/de_DE-all.txt"
        },
        "columns":[ 
            {"title": "Id","data": "id_gcomun",visible:0},
            {"title": "Dpto","data": "numero","width": "3%" },
            {"title": "Propietario","data": "propietario", "width": "20%"},
            {"title": " % Prtje","data": "prorretaje", "width": "5%", 
            "render" : function( data, type, full ) { return formatoPorcentaje(data); }},
            {"title": "Gasto Comun","data": "monto_gcomun_apto", "width": "8%", 
            "render" : function( data, type, full ) { return formatoCentimos(data); }},
            {"title": "Fondo de Reserva","data": "monto_fondo_reserva",  "width": "8%", 
            "render" : function( data, type, full ) { return formatoCentimos(data); }},
            {"title": "Pagos Adicionales","data": "mes_pago_adicional", "width": "8%", 
            "render" : function( data, type, full ) { return formatoCentimos(data); }},
            {"title": "Monto Total Mes","data": "monto_total_deudas",  "width": "8%", 
            "render" : function( data, type, full ) { return formatoCentimos(data); }},
            {"title": "Monto Pagado","data": "monto_total_abonado",  "width": "8%", 
            "render" : function( data, type, full ) { return formatoCentimos(data); }},
            {"title": "Saldo deudor","data": "saldo_deudor",  "width": "8%", 
            "render" : function( data, type, full ) { return formatoCentimos(data); }},
            {"title": "Saldo a favor","data": "saldo_a_favor",  "width": "8%", 
            "render" : function( data, type, full ) { return formatoCentimos(data); }},
            {"title": "Deuda","data": "deuda",  "width": "8%", 
            "render" : function( data, type, full ) { return formatoCentimos(data); }},
            {"title": "Sede","data": "id_sede",visible:0}
        ],
    });

};


var cargarResumenGastosMes = function(data){
    $("#tablaResumenGastosComunes").dataTable({
        "paging":  false,
        "ordering": false,
        "info":     false,
        "searching": false,
        "data": data,
        "language": {
            "url": "/DataTables-1.10.10/de_DE-all.txt"
        },
        "columns":[
            {"title": "Fecha de Facturacion", "data": "fecha_inicio"},
            {"title": "Mes de Facturación","data": "mes_inicio"},
            {"title": "Monto de Gastos Comunes","data": "gastos_comunes",
            "render" : function( data, type, full ) { return formatoCentimos(data); }
            },
            {"title": "Monto de Pagos Adicionales","data": "gastos_adicionales",
            "render" : function( data, type, full ) { return formatoCentimos(data); }
            },
            {"title": "Monto de Fondo De Reserva","data": "fondo_reserva", 
            "render" : function( data, type, full ) { return formatoCentimos(data); }
            }
        ],
    });
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

var cargarTablaDetalle = function(data){
    $("#TablaDetalle").dataTable({
        "paging":   false,
        "searching": false,
        "info": false,
        "scrollY":        "200px",
        "scrollCollapse": true,
        "columnDefs": [
        {
            "targets": -1,
            "data": null,
            "searchable": false,
        }
        ],
        "language": {
            "url": "/DataTables-1.10.10/de_DE-all.txt"
        },
        "data": data,
        "columns":[
        {"title": "Id","data": "id",visible:0},
        {"title": "Concepto(s)","data": "text"}
        ],
    });
};

var cargarTablaApartamentos = function(data){
    $("#tablaApartamentos").dataTable({
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
            {"title": "Id","data": "id_apartamento",visible:0},
            {"title": "Propietario","data": "propietario"},
            {"title": "Nro de Departamento", "data": "numero"},
            {"title": "Sede","data": "id_sede",visible:0},
            {"title": "id_usuario","data": "id_usuario",visible:0}
        ],
    });
    SeleccionarTablaApartamentos();
};


var crearallcombos = function(data){

    crearcombo('#id_tipo_padre',data.v_tipo_padre);
    crearcombo('#id_tipo_gasto',data.v_tipo_padre);
    crearcombo('#id_tipo_gastoP',data.v_tipo_padre);
    crearcombo('#mes',mes);
    crearcombo('#anios',data.v_anios);
    crearcombo('#id_apartamento', data.v_apartamentos_cbo);
    crearcombo('#id_concepto_detalle','');
    crearcombo('#id_concepto_detalle_g','');
}

var mostrarConceptosTipo= function(caso){
    if (caso==1){
        switch (parseInt($("#id_tipo_gasto").val())) {
            case 1:
                id_tipo_gasto=1;
            break;
            case 2:
                id_tipo_gasto=2;
            break;
            case 3:
                id_tipo_gasto=3;
            break;
            case 4:
                id_tipo_gasto=4;
            break;
            default:
                id_tipo_gasto=0;
            break;
        }
    }
    if (caso==2){
        switch (parseInt($("#id_tipo_gastoP").val())) {
            case 1:
                id_tipo_gasto=1;
            break;
            case 2:
                id_tipo_gasto=2;
            break;
            case 3:
                id_tipo_gasto=3;
            break;
            case 4:
                id_tipo_gasto=4;
            break;
            default:
                id_tipo_gasto=0;
            break;
        }
    }
    if (caso==3){
        switch (parseInt($("#id_tipo_padre").val())) {
            case 1:
             id_tipo_gasto=1;
            break;
            case 2:
             id_tipo_gasto=2;
            break;
            case 3:
             id_tipo_gasto=3;
            break;
            case 4:
             id_tipo_gasto=4;
            break;
            default:
             id_tipo_gasto=0;
            break;
        }
    }
    BuscarCatalogoConcepto(id_tipo_gasto,caso);
}
// --------------- ajax
var ProcesarPagos = function(){
     $('#id_periodo').val(d.periodos_pago);
    var form = $('#FormGasto').get(0);
    var formData = new FormData(form);
    parametroAjax.data = formData;
    parametroAjax.ruta=rutaP;
    respuesta=procesarajaxfile(parametroAjax);
    ManejoRespuestaRegistrarP(respuesta);
};
var ProcesarPagosAdicionales = function(){
    var id_periodo = {'id_periodo': d.periodos_pago}
    parametroAjax.data = $("#FormPagosA").serialize() + '&' + $.param(id_periodo);
    parametroAjax.ruta=rutaPA;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaRegistrarPA(respuesta);
};
var BuscarCatalogoConcepto = function(id_tipo_gasto,caso){
    parametroAjax.data = {id_tipo_gasto:id_tipo_gasto,caso:caso};
    parametroAjax.ruta=rutaComboD;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarCombo(respuesta);
};
var ProcesarCatalogo = function(){
    parametroAjax.data = $("#FormCatalogo").serialize();
    parametroAjax.ruta=rutaC;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscarP(respuesta);
};
var eliminarGastoAdicional= function(id_pago_adicional){
    parametroAjax.data = {id_pago_adicional:id_pago_adicional};
    parametroAjax.ruta=rutaEliminarPA;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaEliminarPA(respuesta);
}

var eliminarGasto= function(id_pago_gcomun){
    parametroAjax.data = {id_pago_gcomun:id_pago_gcomun};
    parametroAjax.ruta=rutaEliminarP;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaEliminarP(respuesta);
}


var cierreMesFacturacion = function(){
    var id_periodo = {'periodo_pago': d.periodos_pago}
    parametroAjax.data = {id_periodo:id_periodo};
    parametroAjax.ruta=rutaCierre;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaCierreMes(respuesta);
};

var confirmarPagoPropietario = function(data){
    parametroAjax.data = data;
    parametroAjax.ruta=rutaConfirmarP;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaConfirmarPago(respuesta);
};

var rechazarPagoPropietario = function(data){
    parametroAjax.data = data;
    parametroAjax.ruta=rutaRechazarP;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaRechazarPago(respuesta);
};
var consultarPagos = function(){
    var parametros = {'mes': $("#mes").val(), 'anio':$("#anios").val(), 'id_apartamento': $("#id_apartamento").val()}
    parametroAjax.data =  {parametros:parametros};
    parametroAjax.ruta=rutaCGC;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaConsulta(respuesta);
};

var ManejoRespuestaRegistrarP = function(respuesta){

     if (respuesta.code=='200'){
                cancelarCargar();
                mensajesAlerta('Procesado!','Registrado exitosamente', 'info');
                limpiarTablaPagos();
                cargarTablaGastos(respuesta.respuesta.v_gastos);
                limpiarTablaResumenGastosComunes();
                cargarResumenGastosMes(respuesta.respuesta.v_total_gastos);
                limpiarTablaResumenGastosMes();
                cargarTablaGastosConsulta(respuesta.respuesta.v_gastos_consulta);
                limpiarTablaCalculoGastosComunes();
                cargarTablaConsultaGastos(respuesta.respuesta.v_calculo_gcomunes);

     }else{
         mensajesAlerta('Error','Comuniquese con el personal de soporte técnico', 'error');
     }
}


var ManejoRespuestaRegistrarPA = function(respuesta){
    if (respuesta.code=='200'){
        var res = JSON.parse(respuesta.respuesta.f_registro_pagos_adicionales[0].f_registro_pagos_adicionales);
        switch(res.code) {
            case '200':
                    cerrarPagosAdicionales();
                    mensajesAlerta('Procesado!',res.des_code, 'info');

                    limpiarTablaPagos();
                    cargarTablaGastos(respuesta.respuesta.v_gastos);
                    limpiarTablaPagosAdicionales();
                    cargarTablaGastosAdicionales(respuesta.respuesta.v_gastos_adicionales);
                    limpiarTablaResumenGastosComunes();
                    cargarResumenGastosMes(respuesta.respuesta.v_total_gastos);
                    limpiarTablaResumenGastosMes();
                    cargarTablaGastosConsulta(respuesta.respuesta.v_gastos);
                    limpiarTablaCalculoGastosComunes();
                    cargarTablaConsultaGastos(respuesta.respuesta.v_calculo_gcomunes);
                    limpiarTablaPagosAdicionalesConsulta();
                    cargarTablaGastosAdicionalesConsulta(respuesta.respuesta.v_gastos_adicionales);

                break;
            case '-2':
                mensajesAlerta('Error',res.des_code, 'error');
                break;
            default:
                mensajesAlerta('Error','Comuniquese con el personal de soporte técnico', 'error');
        }
    }else{
        mensajesAlerta('Error','Comuniquese con el personal de soporte técnico', 'error');
    }
}
var ManejoRespuestaEliminarP = function(respuesta){

    if (respuesta.code == '200'){
        $('#modalGasto').window('close');
        mensajesAlerta('Procesado!','Su solicitud ha sido procesada', 'info');

        limpiarTablaPagos();
        cargarTablaGastos(respuesta.respuesta.v_gastos);
        limpiarTablaPagosAdicionales();
        cargarTablaGastosAdicionales(respuesta.respuesta.v_gastos_adicionales);
        limpiarTablaResumenGastosComunes();
        cargarResumenGastosMes(respuesta.respuesta.v_total_gastos);
        limpiarTablaResumenGastosMes();
        cargarTablaGastosConsulta(respuesta.respuesta.v_gastos);
        limpiarTablaCalculoGastosComunes();
        cargarTablaConsultaGastos(respuesta.respuesta.v_calculo_gcomunes);
        limpiarTablaPagosAdicionalesConsulta();
        cargarTablaGastosAdicionalesConsulta(respuesta.respuesta.v_gastos_adicionales);

    }else{
        mensajesAlerta('Error','Comuniquese con el personal de soporte técnico', 'error');
    }
}
var eliminarGastoComun = function(){
    eliminarGasto(Registrogasto.id_pago_gcomun);
}


var ManejoRespuestaEliminarPA = function(respuesta){
    if (respuesta.code=='200'){
        mensajesAlerta('Procesado!','Su solicitud ha sido procesada', 'info');

        limpiarTablaPagos();
        cargarTablaGastos(respuesta.respuesta.v_gastos);
        limpiarTablaPagosAdicionales();
        cargarTablaGastosAdicionales(respuesta.respuesta.v_gastos_adicionales);
        limpiarTablaResumenGastosComunes();
        cargarResumenGastosMes(respuesta.respuesta.v_total_gastos);
        limpiarTablaResumenGastosMes();
        cargarTablaGastosConsulta(respuesta.respuesta.v_gastos);
        limpiarTablaCalculoGastosComunes();
        cargarTablaConsultaGastos(respuesta.respuesta.v_calculo_gcomunes);
        limpiarTablaPagosAdicionalesConsulta();
        cargarTablaGastosAdicionalesConsulta(respuesta.respuesta.v_gastos_adicionales);

    }else{
        mensajesAlerta('Error','Comuniquese con el personal de soporte técnico', 'error');
    }
}

var ManejoRespuestaCierreMes = function(respuesta){
     if (respuesta.code=='200'){
         var res = JSON.parse(respuesta.respuesta.f_registro_cierre_mes[0].f_registro_cierre_mes);
         switch(res.code) {
            case '200':
                $('#modalCierre').window('close');
                mensajesAlerta('Procesado!',res.des_code, 'info');
                limpiarTablaPagos();
                cargarTablaGastos(respuesta.respuesta.v_gastos);
                limpiarTablaPagosAdicionales();
                cargarTablaGastosAdicionales(respuesta.respuesta.v_gastos_adicionales);
                limpiarTablaResumenGastosComunes();
                cargarResumenGastosMes(respuesta.respuesta.v_total_gastos);
                limpiarTablaResumenGastosMes();
                cargarTablaGastosConsulta(respuesta.respuesta.v_gastos);
                limpiarTablaCalculoGastosComunes();
                cargarTablaConsultaGastos(respuesta.respuesta.v_calculo_gcomunes);
                limpiarTablaPagosAdicionalesConsulta();
                cargarTablaGastosAdicionalesConsulta(respuesta.respuesta.v_gastos_adicionales);
                break;
            case '-2':
                mensajesAlerta('Error',res.des_code, 'error');
                break;
            default:
                mensajesAlerta('Error','Comuniquese con el personal de soporte técnico', 'error');
          }
     }else{
         mensajesAlerta('Error','Comuniquese con el personal de soporte técnico', 'error');
     }
}


var ManejoRespuestaConsulta = function(respuesta){

      if (respuesta.code=='200'){

        limpiarTablaResumenGastosComunes();
        cargarResumenGastosMes(respuesta.respuesta.v_totales_mes);
        v_totales_mes = respuesta.respuesta.v_totales_mes;
        limpiarTablaResumenGastosMes();
        cargarTablaGastosConsulta(respuesta.respuesta.v_gastos);
        v_gastos = respuesta.respuesta.v_gastos;
        limpiarTablaPagosAdicionalesConsulta();
        cargarTablaGastosAdicionalesConsulta(respuesta.respuesta.v_gastos_adicionales);
        v_gastos_adicionales = respuesta.respuesta.v_gastos_adicionales;
        limpiarTablaCalculoGastosComunes();
        cargarTablaConsultaGastos(respuesta.respuesta.v_calculo_gcomunes);
        v_gastos_adicionales = respuesta.respuesta.v_calculo_gcomunes;
      }else{
         mensajesAlerta('Error','Comuniquese con el personal de soporte técnico', 'error');
     }
}

var ManejoRespuestaConfirmarPago = function(respuesta){

     if (respuesta.code=='200'){
        mensajesAlerta('Procesado!','El pago fue confirmado exitosamente','info');
        limpiarTablaPagosPropietarios();
        cargarTablaPagosPropietario(respuesta.respuesta.v_pagos_propietarios);
     }else{
         mensajesAlerta('Error','Comuniquese con el personal de soporte técnico', 'error');
     }
}

var ManejoRespuestaRechazarPago = function(respuesta){
     if (respuesta.code=='200'){
        mensajesAlerta('Procesado!','El pago fue rechazado exitosamente','info');
        limpiarTablaPagosPropietarios();
        cargarTablaPagosPropietario(respuesta.respuesta.v_pagos_propietarios);
        //visualizarAcumulados(respuesta.respuesta.v_totales_mes);
        limpiarTablaPagos();
        cargarTablaGastos(respuesta.respuesta.v_gastos);
        limpiarTablaGastosComunes();
        cargarTablaGastosComunes(respuesta.respuesta.v_gastos);
    //      limpiarTablaCalculoGcomunes();
     //   cargarTablaCalculoGcomunes(respuesta.respuesta.v_calculo_gcomunes);
     }else{
         mensajesAlerta('Error','Comuniquese con el personal de soporte técnico', 'error');
     }
}


var ManejoRespuestaBuscarCombo = function(respuesta){
    if (respuesta.code=='200'){
        if (respuesta.respuesta.caso=='1'){
            $('#id_concepto_detalle_g').empty();
            crearcombo('#id_concepto_detalle_g',respuesta.respuesta.v_conceptos);
        }
        if (respuesta.respuesta.caso=='2'){
            $('#id_concepto_detalle').empty();
            crearcombo('#id_concepto_detalle',respuesta.respuesta.v_conceptos);
        }
        if (respuesta.respuesta.caso=='3'){
            destruirTablaS('TablaDetalle');
            cargarTablaDetalle(respuesta.respuesta.v_conceptos);
        }
    }
}

var ManejoRespuestaBuscarP = function(respuesta){
    if (respuesta.code=='200'){
        var res = JSON.parse(respuesta.respuesta.f_registro);
        switch(res.code) {
            case '200':
                destruirTablaS('TablaDetalle');
                cargarTablaDetalle(respuesta.respuesta.v_catalogo);
                mensajesAlerta('Procesado!',res.des_code, 'info');
                $(".descripcion").val("");
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

var mostrarApartamentos = function(){
    $('#modalApartamentos').window('open');
}

var asignarFecha = function(){
    $('#modalAsignarFecha').window('open');
}

var cierreMes = function(){
        $('#modalCierre').window('open');
};

var cargarTotalesCierre = function(data){

    if(data[0].fecha_inicio!=null){$(".fecha_facturacion_mes").text(data[0].fecha_inicio);}
    if(data[0].mes_inicio!=null){$(".mes_facturacion").text(data[0].mes_inicio);}
    if(data[0].gastos_comunes!=null){$(".mto_gastos_comunes").text(data[0].gastos_comunes + '$');}
    if(data[0].gastos_adicionales!=null){$(".mto_pagos_adicionales").text(data[0].gastos_adicionales + '$');}
    if(data[0].fondo_reserva!=null){$(".mto_fondo_reserva").text(data[0].fondo_reserva + '$');}
}

var visualizarGasto = function(RegistroGasto){
    if(RegistroGasto.tipo_gasto!=null){$(".tipo_gasto").text(RegistroGasto.tipo_gasto);}
    if(RegistroGasto.concepto_detalle!=null){$(".concepto_detalle").text(RegistroGasto.concepto_detalle);}
    if(RegistroGasto.descripcion!=null){$(".descripcion").text(RegistroGasto.descripcion);}
    if(RegistroGasto.fecha_factura!=null){$(".fecha_factura").text(RegistroGasto.fecha_factura);}
    if(RegistroGasto.urlimage!=null){$(".urlimage").text(RegistroGasto.urlimage);}
    if(RegistroGasto.monto!=null){$(".monto").text(RegistroGasto.monto);}
    if(RegistroGasto.fecha_carga!=null){$(".fecha_carga").text(RegistroGasto.fecha_carga);}
    if(RegistroGasto.urlimage!=null){$(".urlimage").text(RegistroGasto.urlimage);}
    $('#modalGasto').window('open');
}



// var visualizarAcumulados = function(data){
//     if(data.fecha_inicio!=null){$(".fecha_inicio").text(data.fecha_inicio);}
//     if(data.fecha_corte!=null){$(".fecha_corte").text(data.fecha_corte);}
//     if(data.gastos_comunes!=null){$(".gastos_comunes").text(data.gastos_comunes);}
//     if(data.gastos_adicionales!=null){$(".gastos_adicionales").text(data.gastos_adicionales);}
// }

var SeleccionarTablaApartamentos = function(data){
    var tableApartamento = $('#tablaApartamentos').dataTable();
    $('#tablaApartamentos tbody').on('click', 'tr', function (e) {
        tableApartamento.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroApartamento= TablaTraerCampo('tablaApartamentos',this);
    });
    tableApartamento.on('dblclick', 'tr', function () {
        $(".id_apartamento").val(RegistroApartamento.id_apartamento);
        $("#id_usuario").val(RegistroApartamento.id_usuario);
        $("#numero_apto").text(RegistroApartamento.propietario + ", Apartamento # " + RegistroApartamento.numero);
        $('#modalApartamentos').window('close');
    });
}

var cargarPagosA = function(){
     $('.divConsulta').hide();
     $('.divGastos').hide();
     $('.divCatalogo').hide();
     $('.divCalculoPrevio').hide();
     $('.divCalculoPrevio').hide();
     $('.divPagosPropietarios').hide();
     $('.divPagosA').show();
     $(".boton1").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
     $(".boton2").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
     $(".boton3").removeClass( "botonNoSeleccion" ).addClass("botonSeleccion");
     $(".boton4").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
     $(".boton5").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
}

var mostrarGastos = function(){
    $('.divConsulta').hide();
    $('.divCargar').hide();
    $('.divCatalogo').hide();
    $('.divPagosA').hide();
    $('.divCalculoPrevio').hide();
    $('.divPagosPropietarios').hide();
    $('.divGastos').show();
    $(".boton1").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
    $(".boton2").removeClass( "botonNoSeleccion" ).addClass("botonSeleccion");
    $(".boton3").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
    $(".boton4").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
    $(".boton5").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
}

var mostrarPagosPropietarios = function(){
    $('.divConsulta').hide();
    $('.divCargar').hide();
    $('.divCatalogo').hide();
    $('.divPagosA').hide();
    $('.divCalculoPrevio').hide();
    $('.divGastos').hide();
    $('.divPagosPropietarios').show();
    $(".boton1").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
    $(".boton2").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
    $(".boton3").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
    $(".boton4").removeClass( "botonNoSeleccion" ).addClass("botonSeleccion");
    $(".boton5").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
}

var calculoPrevio = function(){
    $('.divConsulta').hide();
    $('.divCargar').hide();
    $('.divCatalogo').hide();
    $('.divPagosA').hide();
    $('.divGastos').hide();
    $('.divPagosPropietarios').hide();
    $('.divCalculoPrevio').show();
}

var MostrarCatalogos = function(){
    $('.divConsulta').hide();
    $('#FormCatalogo')[0].reset();
    $('.divGastos').hide();
    $('.divPagosA').hide();
    $('.divCatalogo').show();
    $('.divCalculoPrevio').hide();
    $('.divPagosPropietarios').hide();
    $("#spanTituloEncuesta").text("Registro de conceptos de pago");
    $(".boton1").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
    $(".boton2").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
    $(".boton3").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
    $(".boton4").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
    $(".boton5").removeClass( "botonNoSeleccion" ).addClass("botonSeleccion");
}

var VolverCatalogos = function(){
    $('.divConsulta').hide();
    $('.divCatalogo').hide();
    $('.divPagosA').hide();
    $('.divCalculoPrevio').hide();
    $('.divPagosPropietarios').hide();
    $('.divGastos').show();
}

var consultarGastos = function(){
    $('.divConsulta').show();
    $('.divCatalogo').hide();
    $('.divPagosA').hide();
    $('.divCalculoPrevio').hide();
    $('.divPagosPropietarios').hide();
    $('.divGastos').hide();
    $(".boton1").removeClass( "botonNoSeleccion" ).addClass("botonSeleccion");
    $(".boton2").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
    $(".boton3").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
    $(".boton4").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
    $(".boton5").removeClass( "botonSeleccion" ).addClass("botonNoSeleccion");
}

//---------------   CERRAR VENTANAS

var cancelarCargar = function(){
    $('#divCargar').window('close');
}
var cancelarModalCargar = function(){
    $('#modalGasto').window('close');
}

var cargarGasto = function(){
    $('#divCargar').window('open');
}
var cargarGastoCerrar = function(){
    $('#divCargar').window('close');
}
var cargarGastoAdicional = function(){
    $('#divPagosAR').window('open');
}
var cerrarPagosAdicionales = function(){
    $('#divPagosAR').window('close');
}
var cancelarFecha = function(){
    $('#modalAsignarFecha').window('close');
}
var descargarImagen= function(){
  OpenWindowWithPost('/reportes/visualizar_factura.php','','_blank',Registrogasto);
}
var cerrarCierreMes = function(){
    $('#modalCierre').window('close');
}
var limpiarTablaPagosAdicionales = function(){destruirTablaS('tablaGastosAdicionales');};
var limpiarTablaPagos = function(){destruirTablaS('tablaGastos');};
var limpiarTablaCalculoGcomunes = function(){ destruirTablaS('tablaCalculoGcomunes');};
var limpiarTablaGastosComunes = function(){destruirTablaS('tablaGastosComunes');}
var limpiarTablaPagosPropietarios = function(){destruirTablaS('tablaPagosPropietarios');};
var limpiarTablaGastosComunesConsulta = function(){destruirTablaS('tablaConsultaGastos');};
var limpiarTablaResumenGastos = function(){destruirTablaS('tablaResumenGastosMes');};
var limpiarTablaResumenGastosComunes = function(){destruirTablaS('tablaResumenGastosComunes');};
var limpiarTablaResumenGastosMes = function(){destruirTablaS('tablaResumenGastosMes');};
var limpiarTablaCalculoGastosComunes = function(){destruirTablaS('tablaConsultaGastos');};
var limpiarTablaPagosAdicionalesConsulta = function(){destruirTablaS('tablaGastosAdicionalesConsulta');};

// -------------------  validadores
var validarC=function(){$('#FormCatalogo').formValidation('validate');};
var validarPago=function(){$('#FormGasto').formValidation('validate');};
var validarPagosAdicionales=function(){$('#FormPagosA').formValidation('validate');};
var mostrarCal = function (){$("#fecha_factura").focus();};
var validarConsulta=function(){$('#FormConsulta').formValidation('validate');};


$(document).ready(function(){

    $(document).on('click','#divConsulta',consultarGastos);
    $(document).on('click','#agregarGasto',cargarGasto);
    $(document).on('click','#guardarCargarPago',validarPago);
    $(document).on('click','#agregarGastoA',cargarGastoAdicional);
    $(document).on('click','#cerrarPagosAdicionales',cerrarPagosAdicionales);
    $(document).on('click','#cancelarCargar',cancelarCargar);
    $(document).on('click','#cancelarModalGasto',cancelarModalCargar);
    $(document).on('click','#divGastos',mostrarGastos);
    $(document).on('click','#divPagosA',cargarPagosA);
    $(document).on('click','#btnApartamento',mostrarApartamentos);
    $(document).on('click','#spanConceptos',MostrarCatalogos);
    $(document).on('click','#volverC',VolverCatalogos);
    $(document).on('click','#cargarC',validarC);
    $(document).on('click','#guardarPagosAdicionales',validarPagosAdicionales);
    $(document).on('click','#calculoPrevio',calculoPrevio);
    $(document).on('click','.cal',mostrarCal);
    $(document).on('click','#divPagosPropietarios',mostrarPagosPropietarios);
    $(document).on('click','#cierreMes',cierreMes);
    $(document).on('click','#consultaPagos',validarConsulta);
    $(document).on('click','#asignarFecha',asignarFecha);
    $(document).on('click','#cancelarFecha',cancelarFecha);
    $(document).on('click','#eliminarGasto',eliminarGastoComun);
    $(document).on('click','#cancelarCierre',cerrarCierreMes);
    $(document).on('click','#confirmarCierre',cierreMesFacturacion);
    $(document).on('click','#imprimirGasto',imprimirGasto);
    $(document).on('click','#descargarImagen',descargarImagen);

    $(".boton1").addClass( "botonSeleccion" );
    $(".boton2").addClass( "botonNoSeleccion" );
    $(".boton3").addClass( "botonNoSeleccion" );
    $(".boton4").addClass( "botonNoSeleccion" );
    $(".boton5").addClass( "botonNoSeleccion" );
    // formatos

    $('.moneda').priceFormat({
        prefix:'',
        thousandsSeparator: '.',
        centsLimit: 0
    });
    // $('.moneda').priceFormat({
    //     prefix:'',
    //     centsSeparator:',',
    //     thousandsSeparator:'.'
    // });


    var fecha_f = $('#fecha_factura').datetimepicker();
    var fecha_facturacion = $('#fecha_facturacion').datetimepicker();

    //Combos
    $("#id_tipo_gasto").change(function(){
        mostrarConceptosTipo(1);
    });
    $("#id_tipo_gastoP").change(function(){
        mostrarConceptosTipo(2);
    });
    $("#id_tipo_padre").change(function(){
        mostrarConceptosTipo(3);
    });

    //Modales
    cargarTablaGastos(d.v_gastos);
    cargarTablaGastosConsulta(d.v_gastos_consulta);
    cargarTablaConsultaGastos(d.v_calculo_gcomunes);
    cargarTablaGastosAdicionales(d.v_gastos_adicionales);
    cargarTablaGastosAdicionalesConsulta(d.v_gastos_adicionales_consulta);
    cargarTablaGastosComunes(d.v_gastos);
   // cargarTablaCalculoGcomunes(d.v_calculo_gcomunes);
    cargarTablaApartamentos(d.v_apartamentos);
    cargarTablaPagosPropietario(d.v_pagos_propietarios);
    cargarResumenGastosMes(d.v_total_gastos);
    cargarTotalesCierre(d.v_total_gastos);
    crearallcombos(d);
  //  visualizarAcumulados(d.v_totales_mes);

    //Traer valores de las Tablas
    var tableB = $('#tablaGastos').dataTable();
    $('#tablaGastos tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        Registrogasto = TablaTraerCampo('tablaGastos',this);

        visualizarGasto(Registrogasto);
    });
    tableB.on('dblclick', 'tr', function () {
        $('#close').trigger('click');
    });


    var tablaPagosP = $('#tablaPagosPropietarios').dataTable();
    $('#tablaPagosPropietarios tbody').on('click', 'tr', function (e) {
        tablaPagosP.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroPagoPropietario = TablaTraerCampo('tablaPagosPropietarios',this);
    });
    tablaPagosP.on('dblclick', 'tr', function () {
        $('#close').trigger('click');
    });


    var tableGastosAdicionales = $('#tablaGastosAdicionales').dataTable();
    $('#tablaGastosAdicionales tbody').on('click', 'tr', function (e) {
        tableGastosAdicionales.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        Registrogastoadicional = TablaTraerCampo('tablaGastosAdicionales',this);
    });
    tableGastosAdicionales.on('dblclick', 'tr', function () {
        $('#close').trigger('click');
    });
     $(function() {
        $.contextMenu({
            selector: '#tablaGastosAdicionales',
            callback: function(key, options) {
                switch(key) {
                    case "1":
                        eliminarGastoAdicional(Registrogastoadicional);
                        break;
                }
            },
            items: {
                "1": {name: "Eliminar", icon: "delete"},
            }
        });
    });

    $(function() {
        $.contextMenu({
            selector: '#tablaPagosPropietarios',
            callback: function(key, options) {
                switch(key) {
                    case "1":
                              if(RegistroPagoPropietario.estatus =='A') {
                                    confirmarPagoPropietario(RegistroPagoPropietario);
                              } else{
                                    mensajesAlerta('Error','No puede cambiar el estatus del Pago, registre uno nuevo', 'error');
                              } 
                         
                        break;
                    case "2":

                            if(RegistroPagoPropietario.estatus =='A') {
                                    rechazarPagoPropietario(RegistroPagoPropietario);
                              } else{
                                    mensajesAlerta('Error','No puede cambiar el estatus del Pago, registre uno nuevo', 'error');
                              } 

                        break;
                }
            },
            items: {
                "1": {name: "Confirmar", icon: "edit"},
                "2": {name: "Rechazar", icon: "delete"},
            }
        });
    });

    $("#TablaDetalle").dataTable({
        "paging":   false,
        "searching": false,
        "info": false,
        "columnDefs": [
        {
            "targets": -1,
            "data": null,
            "targets": [ 1 ],
            "searchable": false,
        }
        ],
       "columns":[
            {"title": "Id","data": "id_concepto_detalle",visible:0},
            {"title": "Concepto(s)","data": "descripcion"}
        ],
         "language": {
            "url": "/DataTables-1.10.10/de_DE-all.txt"
        },
    });

    $('#FormCatalogo').formValidation({
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'id_tipo_padre': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'descripcion': {
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
        ProcesarCatalogo();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });

    $('#FormConsulta').formValidation({
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'mes': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'anios': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            }
        }
    })
    .on('success.form.fv', function(e){
      consultarPagos();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });


    $('#FormPagosA').formValidation({
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'id_tipo_gastoP': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'id_concepto_detalle': {
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
            'descripcion': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },

        }
    }).on('success.form.fv', function(e){

        ProcesarPagosAdicionales();
    }).on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });


  $('#FormGasto').formValidation({
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'id_tipo_gastoP': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'id_concepto_detalle': {
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
            'descripcion': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'urlimage': {
                validators: {
                    notEmpty: {
                        message: 'Por favor, cargue la imagen de la factura.'
                    },
                    file: {
                        extension: 'jpeg,jpg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 2097152,   // 2048 * 1024
                        message: 'El archivo cargado no es válido'
                    }
                }
            },
            'fecha_factura': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },

        }
    }).on('success.form.fv', function(e){

        ProcesarPagos();
    }).on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });

});