var mesage=function(tipo,msj){
    // tipo 1 bien
    // tipo 2 error
    switch(tipo){
        case 1:
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_SUCCESS,
                title: 'Aviso',
                message: msj,
                buttons: [{
                    label: 'Aceptar',
                    action: function(dialogItself) {
                        dialogItself.close();
                    }
                }]
            });
            break;
        case 2:
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_WARNING,
                title: 'Aviso',
                message: msj,
                buttons: [{
                    label: 'Aceptar',
                    action: function(dialogItself) {
                        dialogItself.close();
                    }
                }]
            });
            break;
    }
};
//Jquery
var crearfecha = function(control){
    $(control).datepicker({
        format: "dd/mm/yyyy",
        onRender: function(date) {
                // return date.valueOf() < now.valueOf() ? 'disabled' : '';
            },
        }).on('changeDate', function(e){
    });
}
//////////////////////////////////////crear select 2 jquery /////////////////////////////////////////////////////
var crearcombo = function(control, data){
    $(control).select2({
        placeholder: "Seleccione...",
        allowClear: true,
        data: data
    }).on("change",function(e){
        $(this).blur();
    });
}
///////////////////////////////////////////////////// FILTRAR OBJECTO //////////////////////////////////////////////////////
function filtrar_objeto(my_object, my_criteria){
  return my_object.filter(function(obj) {
    return Object.keys(my_criteria).every(function(c) {
      return obj[c] == my_criteria[c];
    });
  });
}
///////////////////////////////////////////////////// AJAX //////////////////////////////////////////////////////
var procesarajax = function(datos){
    var resp = '';
    $.ajax({
        url:datos.ruta,
        headers: {'X-CSRF-TOKEN': datos.token},
        type:datos.tipo,
        async: datos.async,
        dataType: 'JSON',
        data: datos.data,
    })
    .done(function(response) {
        resp = {'code': '200', 'respuesta':response};
    })
    .fail(function (jqXHR, exception) {
        var msg = '';
        if (jqXHR.status === 0) {
            msg = 'Not connect.\n Verify Network.';
        } else if (jqXHR.status == 422){
            msg = 'Validación';
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
         resp = {'code': 'error', 'mensaje': msg, 'detalle':jqXHR};
        // mensajesAlerta('Error',msg, 'error');
    });
    return resp;
};

var procesarajaxfile = function(datos){
    var resp = '';
    $.ajax({
        headers: {'X-CSRF-TOKEN': datos.token},
        url: datos.ruta,
        type: datos.tipo,
        async: datos.async,
        data: datos.data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response){
            resp = {'code': '200', 'respuesta':response};
        },
        error: function(jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 422){
                msg = 'Validación';
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
            resp = {'code': 'error', 'mensaje': msg, 'detalle':jqXHR};
        }

    });
    return resp;
};

///////////////////////////////////////////////////// DATATABLE //////////////////////////////////////////////////////
var destruirTablaS = function(tabla){
    if ($('#'+tabla).dataTable()){
        $('#'+tabla).dataTable().fnClearTable();
        $('#'+tabla).dataTable().fnDraw();
        $('#'+tabla).dataTable().fnDestroy();
        // $('#'+tabla+" thead").empty();
    }
};

var TabalRegistroSelected = [];
var lenguajeTabla = {
    "sProcessing": "Procesando...",
    "sLengthMenu": "Ver listado de _MENU_",
    "sZeroRecords": "No hay registros seleccionados",
    "sInfo": "_START_ al _END_ de _TOTAL_ registros",
    "sInfoEmpty": "0 al 0 de 0 registros",
    "sInfoFiltered": "(filtrado de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Filtrar : ",
    "sUrl": "",
    "oPaginate": {
        "sFirst":    "Primero",
        "sPrevious": "Anterior",
        "sNext":     "Siguiente",
        "sLast":     "\u00daltimo"
    }
};

var cambionacionalidad = function(){
    ($("#nacionalidad").text() == "V")?$("#nacionalidad").text("E"):$("#nacionalidad").text("V");
};

// Selección Multiple
var TablaSeleccionRegitro = function(id_tabla, campo){
    $('#'+id_tabla+' tbody').on( 'click', 'tr', function() {
        var oTable = $('#'+id_tabla).dataTable();
        var iPos = oTable.fnGetPosition(this);
        var datacampo = oTable.fnGetData(iPos);
        var index = $.inArray(datacampo[campo], TabalRegistroSelected);
        if ( index === -1 ) {
            TabalRegistroSelected.push(datacampo[campo]);
        } else {
            TabalRegistroSelected = jQuery.grep(TabalRegistroSelected, function(value) {
              return value != datacampo[campo];
            });
        }
        $(this).toggleClass('selected');
    });
}

var TablaDesSelAll = function(id_tabla){
    var oTable = $('#'+id_tabla).dataTable();
    oTable.$('tr.selected').removeClass('selected');
    TabalRegistroSelected = [];
};

var TablaSelAll = function(id_tabla, campo){
    var oTable = $('#'+id_tabla).dataTable();
    TabalRegistroSelected = [];
    $(oTable.fnGetNodes()).each(function(i) {
        var iPos = oTable.fnGetPosition(this);
        var datacampo = oTable.fnGetData(iPos);
        $(this).addClass('selected');
        TabalRegistroSelected.push(datacampo[campo]);
    });
};

var TablaNroSeleccionado = function(id_tabla){
    var ta = $('#'+id_tabla).DataTable();
    return ta.rows('.selected').data().length;
}

var TablaNroRegistro = function(id_tabla){
    var ta = $('#'+id_tabla).DataTable();
    return ta.data().count();
}

var TablaNroRegistroFil = function(id_tabla){
    var table = $('#'+id_tabla).DataTable();
    var info = table.page.info();
    return info.recordsDisplay;
}

var TablaTraerCampo = function(id_tabla, instancia){
    var oTable = $('#'+id_tabla).dataTable();
    var iPos = oTable.fnGetPosition(instancia);
    var datacampo = oTable.fnGetData(iPos);
    return datacampo;
}

var creartablaMostrarDatos = function(id_tabla,titulos,data){
    $("#" + id_tabla).dataTable({
        "orderCellsTop": true,
        "columnDefs": [
            { "targets": [1], "defaultContent": '' }
        ],
        responsive: true,
        paging:   false,
        ordering: false,
        info:     false,
        bFilter: false,
        bSort:0,
        data: data,
        columns: titulos,
    });
};

var AjustarTabla = function(tabla){
    var oTable = $("#"+tabla).dataTable();
    oTable.fnAdjustColumnSizing();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////

var mes_combo = [{ id: 1, text: 'Enero' }, { id: 2, text: 'Febrero' }, { id: 3, text: 'Marzo' }, { id: 4, text: 'Abril' }, { id: 5, text: 'Mayo' }, { id: 6, text: 'Junio' }, { id: 7, text: 'Julio' }, { id: 8, text: 'Agosto' }, { id: 9, text: 'Septiembre' }, { id: 10, text: 'Octubre' }, { id: 11, text: 'Noviembre' }, { id: 12, text: 'Diciembre' } ];
var mensajesAlerta = function (titulo, mensaje, tipo){
    $.messager.show({
        title: titulo,
        msg:'<div class="messager-icon messager-'+tipo+'"></div><div> '+mensaje,
        timeout:5000,
        showType:'show',
        style:{
            left:'',
            right:0,
            top:document.body.scrollTop+document.documentElement.scrollTop,
            bottom:''
        }
    });
}

var rhtmlspecialchars = function (str) {
    if (typeof(str) == "string") {
    str = str.replace(/&gt;/ig, ">");
    str = str.replace(/&lt;/ig, "<");
    str = str.replace(/&#039;/g, "'");
    str = str.replace(/&quot;/ig, '"');
    str = str.replace(/&amp;/ig, '&'); /* must do &amp; last */
    }
    return str;
}

var tiempotranscurrido = function(fechaI, fechaF){
    if (fechaI + '' == '') return '';

    fechaF || ( fechaF = moment() );
    // var b = moment([1980, 03, 23]);
    var a = moment(moment(fechaF,'DD-MM-YYYY').format('YYYY-MM-DD'));
    var b = moment(moment(fechaI,'DD-MM-YYYY').format('YYYY-MM-DD'));

    var years = a.diff(b, 'year');
    b.add(years, 'years');

    var months = a.diff(b, 'months');
    b.add(months, 'months');

    var days = a.diff(b, 'days');

    // console.log(years + ' año' + ((years>1)?'s ': ' ') + months + ' mes' + ((months>1)?'es ': ' ') + days + ' día' + ((days>1)?'s ': ' '));
    return (years + ' año' + ((years>1)?'s ': ' ') + months + ' mes' + ((months>1)?'es ': ' ') + days + ' día' + ((days>1)?'s ': ' '));
}


// OpenWindowWithPost('public/pdf/Digitalización rápida en ByN a archivo PDF_1.pdf','','fgfgdrg',respuesta);
function OpenWindowWithPost(url, windowoption, name, params){
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", url);
    form.setAttribute("target", name);

    for (var i in params) {
        if (params.hasOwnProperty(i)) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = i;
            input.value = params[i];
            form.appendChild(input);
        }
    }

    document.body.appendChild(form);

    //note I am using a post.htm page since I did not want to make double request to the page
   //it might have some Page_Load call which might screw things up.
    //window.open("post.htm", name, windowoption);

    form.submit();

    document.body.removeChild(form);
}

// SaveToDisk('public/pdf/Digitalización rápida en ByN a archivo PDF_1.pdf','descarga.pdf');
function SaveToDisk(fileURL, fileName) {
    // for non-IE
    if (!window.ActiveXObject) {
        var save = document.createElement('a');
        save.href = fileURL;
        save.target = '_blank';
        save.download = fileName || 'unknown';

        var evt = new MouseEvent('click', {
            'view': window,
            'bubbles': true,
            'cancelable': false
        });
        save.dispatchEvent(evt);

        (window.URL || window.webkitURL).revokeObjectURL(save.href);
    }

    // for IE < 11
    else if ( !! window.ActiveXObject && document.execCommand)     {
        var _window = window.open(fileURL, '_blank');
        _window.document.close();
        _window.document.execCommand('SaveAs', true, fileName || fileURL)
        _window.close();
    }
}

// $.fn.select2.defaults.set('language', 'es');
$(document).ready(function(){
    // alert('Esto es una prueba');
    // cambionacionalidad();
    // toastr.options = {
    //     "closeButton": true,
    //     "timeOut": "2000",
    //     "extendedTimeOut": "1500"
    // };
});