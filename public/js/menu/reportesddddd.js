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
                console.log('llega ddddd');
                break;
            case 3:
            case 1:
                // console.log(response.nombre);
                url = '/reporte/out/'+ response.nombre;
                window.open(url , 'Reporte' , 'fullscreen=no');
                // window.open(url, 'Reporte');
                // SaveToDisk(url,'descarga.pdf');
                break;
            default:
                break;
        }
    })
    .fail(function (jqXHR, exception) {
        var msg = '';
        // console.log(jqXHR.responseJSON);
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

// var destroycombosfechas = function(){
//     if ($('#divfecha_desde').data("DateTimePicker")){
//         $('#divfecha_desde').data("DateTimePicker").destroy();
//     };
//     if ($('#divfecha_hasta').data("DateTimePicker")){
//         $('#divfecha_hasta').data("DateTimePicker").destroy();
//     };
// }

// var crearFecha = function(selector, formato){
//     $(selector).datetimepicker({
//         format: formato,
//         locale: 'es',
//     });
// }

var selecionarReporte = function (id_reporte){
    // console.log("aqui esta el id:"+id_reporte);
    id_reporte = parseInt(id_reporte);
    $('.mostrar').show();
    // switch(id_reporte) {
        // case 1:
        //     // console.log("entre en caso 1");
        //     $('#divfechahasta').hide();
        //     destroycombosfechas();
        //     crearFecha('.fecha','DD/MM/YYYY');
        //     break;
        // case 2:
            // console.log("entre en caso 2");
            // destroycombosfechas();
            // crearFecha('.fecha','MM/YYYY');
        //     break;
        // case 3:
        // case 1:
            // console.log("entre en caso 3");
            // $('#divCombofecha').hide();

    //         break;
    //     default:
    //         // $('#divCombofecha').hide();
    //     break;
    // }
}

var seleccion = function(id_reporte){
    var table = $('#reportes').DataTable();
    table.rows( function ( idx, data, node ) {
        if (data.id_reporte == id_reporte) $(node).addClass('selected');
    }).data();
};

var procesar = function(){
    console.log("Si llega al procesar js");
    id_reporte = parseInt($('#id_reporte').val());
    // ced= Auth::user()->cedula;
    // console.log(ced);

    console.log(id_reporte);
    switch(id_reporte) {
        case 8: //total fe de vida
            console.log('llega a total fe de vida');
            // procesarajax({'id_reporte':id_reporte}, datos.rutaprocesarconsulta, 3);
            break;
        case 10: //planilla fe de vida
            // console.log("va con id_reporte: "+id_reporte);
            procesarajax({'id_reporte':id_reporte }, datos.rutaprocesarconsulta, 3);
            // console.log('llega a caso 2');
            break;
        case 11: // exclusion a nomina
            console.log('llega a exclusion a nomina');
            break;
        case 12: // no validado
            console.log('llega a no validado');
            break;
        // default:
        //     $('#divCombofecha').hide();
        // break;
    }
}

$(document).ready(function() {
    $('#reportes').DataTable({
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false,
        "data": obj,
        "language": lenguajeTabla,
        "columns": [
            { title: "id_reporte" ,data: "id_reporte", visible:0 },
            { title: "Solicitud" ,data: "des_reporte" },
            { title: "poderes" ,data: "poder" , visible:0}
        ]
    });
    var oTable = $('#reportes').dataTable();

    // Siemnpre uno seleccionado
    $('#reportes tbody').on('click', 'tr', function () {
        oTable.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        $('.has-error').removeClass('has-error');
        $("p").remove(".text-danger");
    });

    $('#reportes').on('click','tbody tr', function(){
        var iPos = oTable.fnGetPosition(this);
        var id_reporte = oTable.fnGetData(iPos);
        $('#id_reporte').val(id_reporte.id_reporte);
        selecionarReporte(id_reporte.id_reporte);
    });

    // NOTA: Inicalizacion del datatable. activa y desactiva los filtros del reporte
    if ($('#id_reporte').val()){
        seleccion($('#id_reporte').val());
        selecionarReporte($('#id_reporte').val());
    }else{
        selecionarReporte(1);
        seleccion(1);
        $('#id_reporte').val(1);
    }

    $(document).on('click','#aceptar',procesar);

});