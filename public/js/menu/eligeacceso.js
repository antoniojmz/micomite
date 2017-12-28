$(document).ready(function(){
    $('#accesos').DataTable( {
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         true,
        "data": obj,
        "language": lenguajeTabla,
        "order": [3,'asc'],
        "searchable": true,
        "columns": [
            { title: "Perfil" ,data: "des_nivel"},
            { title: "Condominio" ,data: "des_sede" },
            { title: "Ciudad" ,data: "des_estado" },
            { title: "id_nivel" ,data: "id_nivel",visible:0},
            { title: "id_usuario_acceso" ,data: "id_usuario_acceso",visible:0}
        ]
    });
    var oTable = $('#accesos').dataTable();
    $('#accesos tbody').on('click', 'tr', function () {
        oTable.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        var iPos = oTable.fnGetPosition(this);
        var id_usuario_acceso = oTable.fnGetData(iPos);
        $('#id_usuario_acceso').val(id_usuario_acceso.id_usuario_acceso);
    });
    $('#accesos tbody').on('dblclick', 'tr', function () {
        $("#cambioacceso").submit();
    });
});