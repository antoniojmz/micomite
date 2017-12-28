var Registroreglamento = '';

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

$(document).ready(function(){
    cargarTablaReglamentos(d.v_reglamentos);
    var tableB = $('#tablaReglamentos').dataTable();
    $('#tablaReglamentos tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        Registroreglamento = TablaTraerCampo('tablaReglamentos',this);
        OpenWindowWithPost(rutaD,'','_blank',Registroreglamento);
    });
    tableB.on('dblclick', 'tr', function () {
        $('#close').trigger('click');
    });
    //  $(function() {
    //     $.contextMenu({
    //         selector: '#tablaReglamentos',
    //         callback: function(key, options){
    //             switch(key) {
    //                 case "1":
    //                     OpenWindowWithPost(rutaD,'','_blank',Registroreglamento);
    //                     break;
    //             }
    //         },
    //         items: {
    //             "1": {name: "Visualizar", icon: "edit"},
    //         }
    //     });
    // });
});