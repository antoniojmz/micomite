var Registroinstalacion = '';
var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};
var ManejoRespuesta = function(respuesta){
    if (respuesta.code=200){
        $('#foto-instalacion1').attr('src','/img/home.png')+ '?' + Math.random();
        destruirTablaS('tablaInstalaciones');
        cargarTablaInstalaciones(respuesta.respuesta);         
    }else{
        mensajesAlerta('Error','Ocurrio un error al eliminar las imagenes', 'error');
    }
}
var ManejoRespuestaI = function(respuesta){
    if (respuesta.code=='200'){
    	var res = JSON.parse(respuesta.respuesta.f_registro_instalacion[0].f_registro_instalacion);
    	switch(res.code) {
    	    case '200':
                mensajesAlerta('Procesado!',res.des_code, 'info');
                limpiarTabla();
                cargarTablaInstalaciones(respuesta.respuesta.v_instalaciones);
                agregarFoto();
                $("#id_instalacion").val(res.id_instalacion);
                $("#id_instalacion2").val(res.id_instalacion);
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

var cargarTablaInstalaciones = function(data){
    $("#tablaInstalaciones").dataTable({
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
        {"title": "Id","data": "id_instalacion",visible:0},
        {"title": "Instalación","data": "des_descripcion"},
        {"title": "Descripción","data": "descripcion"},
        {"title": "Activo","data": "activo_instalacion",visible:0},
        {"title": "Sede","data": "id_sede",visible:0}
        ],
    });
};
var Procesarinstalacion = function(){
    var id_descripcion=$('#id_descripcion').val();
    var descripcion= $('#descripcion').val();
    var id_instalacion= $('#id_instalacion').val();
    // if( $('#activo_sede').is(':checked') ){activo_sede='t';}
    parametroAjax.ruta=ruta;
    parametroAjax.data={'id_descripcion':id_descripcion,'descripcion':descripcion,'id_instalacion':id_instalacion};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaI(respuesta);
};
var agregarFoto = function(){$("#cancelar").html(" Volver");$('.divCam').show();}
var crearallcombos = function(data){crearcombo('#id_descripcion',data);}
var cargarForm = function(){
	$('.divCam').hide();
    $('#divTabla').hide();
    $('#divForm').show();
    $("#id_instalacion").val("");
    $('#Forminstalacion')[0].reset();
    $(".comboclear").val('').trigger("change");
}
var cargarTabla = function(){
	limpiar();
    $('#divForm').hide();
    $('#divTabla').show();
	$('.divCam').hide();
	$("#cancelar").html(" Cancelar");
}
var limpiar = function(){
	$("#Forminstalacion")[0].reset();
	$("#FormFotos")[0].reset();
	$("#id_ciudad").val('').trigger("change");
	$("#id_instalacion").val("");
    $("#id_instalacion2").val("");
    $('#foto-instalacion1').attr('src',"/img/home.png")+ '?' + Math.random();      
}
var pintarDatosActualizar= function(data){
    $('#divTabla').hide();
    $('#divForm').show();
	$('.divCam').show();
    if(data.id_instalacion!=null){$("#id_instalacion").val(data.id_instalacion);}
    if(data.id_instalacion!=null){$("#id_instalacion2").val(data.id_instalacion);}
    if(data.id_descripcion!=null){$("#id_descripcion").val(data.id_descripcion).trigger("change");}
    if(data.descripcion!=null){$("#descripcion").val(data.descripcion);}
    if(data.activo_sede='false'){$("#activo_sede").prop("checked", false);}
    if(data.foto1!=null){if (data.foto1.length>3){$('#foto-instalacion1').attr('src',data.foto1)+ '?' + Math.random();}}
    $("#cancelar").html(" Volver");
}
var eliminarFotoC = function(){
    var id_instalacion=$('#id_instalacion2').val();
    parametroAjax.ruta=rutaE;
    parametroAjax.data= {id_instalacion:id_instalacion};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuesta(respuesta);
}
var actualizarFotos = function(){ 
    var formu=$(this);
    var nombreform=$(this).attr("id");
    if(nombreform=="FormFotos" ){ 
        var divresul="notificacion_resul_fci"
    }
        var form = $('#FormFotos').get(0); 
        var formData = new FormData(form);
        //hacemos la petición ajax  
        $.ajax({
            url: rutaF,  
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
            var res=JSON.parse(data);
            	switch(res.code) {
				    case "-2":
                		mensajesAlerta('Error!',res.des_code, 'error');
				    break;
				    case "200":
            			mensajesAlerta('Procesado!',res.des_code, 'info');
		                if(res.foto1!=null){if (res.foto1.length>3){$('#foto-instalacion1').attr('src',res.foto1)+ '?' + Math.random();}}
				        limpiarTabla();
                        cargarTablaInstalaciones(res.v_instalaciones);
                    break;    
				    default:
                		mensajesAlerta('Error!','Error de registro. Intente nuevamente, si el error persite contacte al personal informático.', 'error');
				} 
            },
            error: function(data){
               mensajesAlerta('Error!','ha ocurrido un error al cargar su foto', 'error');
            },
        });
};
var validarC=function(){$('#Forminstalacion').formValidation('validate');};
var limpiarTabla = function(){destruirTablaS('tablaInstalaciones');};
var cargarFotos = function(){$('#divFotos').window('open');}
$(document).ready(function(){
	$("#tituloPantalla").text(d['title']);
	cargarTablaInstalaciones(d.v_instalaciones);
	crearallcombos(d.v_instalaciones_combo);
    $(document).on('click','#guardar',validarC);
    $(document).on('click','#agregar',cargarForm);
    $(document).on('click','#cancelar',cargarTabla);
    $(document).on('click','#guardarF',cargarFotos);
    $(document).on('click','#cargar',actualizarFotos);
    $(document).on('click','#eliminar',eliminarFotoC);

    var tableB = $('#tablaInstalaciones').dataTable();
    $('#tablaInstalaciones tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        Registroinstalacion = TablaTraerCampo('tablaInstalaciones',this);
    });
    tableB.on('dblclick', 'tr', function () {
        $('#close').trigger('click');
    });
     $(function() {
        $.contextMenu({
            selector: '#tablaInstalaciones',
            callback: function(key, options) {
                switch(key) {
                    case "1":
                        pintarDatosActualizar(Registroinstalacion);
                        break;
                }
            },
            items: {
                "1": {name: "Editar", icon: "edit"},
            }
        });
    });

    $('#Forminstalacion').formValidation({
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'id_descripcion': {
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
        Procesarinstalacion();
    }).on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});
