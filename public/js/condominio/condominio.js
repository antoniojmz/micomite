var Registrocondominio = '';
var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};
var ManejoRespuesta = function(respuesta){
    if (respuesta.code=200){
        $('#foto-condominio1').attr('src','/img/home.png')+ '?' + Math.random();
        $('#foto-condominio2').attr('src','/img/home.png')+ '?' + Math.random();
        $('#foto-condominio3').attr('src','/img/home.png')+ '?' + Math.random();
        destruirTablaS('tablaSedes');
        cargarTablaSedes(respuesta.respuesta);
    }else{
        mensajesAlerta('Error','Ocurrio un error al eliminar las imagenes', 'error');
    }
}
var ManejoRespuestaProcesar = function(respuesta){
	var res = JSON.parse(respuesta.f_registro_condominio[0].f_registro_condominio);
	switch(res.code) {
	    case '200':
            mensajesAlerta('Procesado!',res.des_code, 'info');
            limpiarTabla();
            cargarTablaSedes(respuesta.v_sedes);
            agregarFoto();
            $("#id_sede").val(res.id_sede);
            $("#id_sede2").val(res.id_sede);
	        break;
	    case '-2':
	        mensajesAlerta('Error',res.des_code, 'error');
	        break;
	    default:
	        mensajesAlerta('Error','Comuniquese con el personal de sopore técnico', 'error');
	}
}

var cargarTablaSedes = function(data){
    $("#tablaSedes").dataTable({
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
        {"title": "Id","data": "id_sede",visible:0},
        {"title": "Condominio","data": "des_sede"},
        {"title": "Ciudad","data": "des_ciudad"},
        {"title": "Comuna","data": "des_comuna"},
        {"title": "Dirección","data": "direccion"},
        {"title": "Teléfono","data": "telefonos"},
        {"title": "Fondo de Reserva","data": "fondo_reserva"},
        {"title": "Fecha de Inicio de Facturación","data": "fecha_facturacion"}
        ],
    });
};
var Procesarcondominio = function(){
        var id_sede=$('#id_sede').val();
        var des_sede= $('#des_sede').val();
        var telefono= $('#paist').val()+"-"+$('#codigot').val()+"-"+$('#numerot').val();
        var direccion= $('#direccion').val();
        var obs= $('#obs').val();
        var activo_sede = 'f';
        var id_ciudad = $('#id_ciudad').val();
        var id_comuna = $('#id_comuna').val();
        var fecha_facturacion = $('#fecha_facturacion').val();
        var fondo_reserva = $('#fondo_reserva').val();
        if( $('#activo_sede').is(':checked') ){activo_sede='t';}
        datos=[];
        datos = {
            id_sede:id_sede,
            des_sede:des_sede,
            telefono: telefono,
            direccion: direccion,
            obs: obs,
            activo_sede:activo_sede,
            id_ciudad:id_ciudad,
            id_comuna:id_comuna,
            fecha_facturacion:fecha_facturacion,
            fondo_reserva:fondo_reserva
        };
        $.ajax({
            url: ruta,
            headers: {'X-CSRF-TOKEN': $('#_token').val()},
            type:'POST',
            async:false,
            dataType: 'JSON',
            data: {
                'datos':datos
            },
        })
        .done(function(d){
            ManejoRespuestaProcesar(d);
        });
};
var agregarFoto = function(){$("#cancelar").html(" Volver");$('.divCam').show();}
var crearallcombos = function(){crearcombo('#id_ciudad','');crearcombo('#id_comuna','')}
var mostrarCal = function (){$("#fecha_facturacion").focus();};
var fecha_facturacion = $('#fecha_facturacion').datetimepicker();

var cargarForm = function(){
	$('.divCam').hide();
    $('#divTabla').hide();
    $('#divForm').show();
    $("#id_sede").val("");
    $('#FormCondominio')[0].reset();
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
	$("#FormCondominio")[0].reset();
	$("#FormFotos")[0].reset();
    $("#id_ciudad").val('').trigger("change");
	$("#id_comuna").val('').trigger("change");
	$("#id_sede").val("");
    $("#id_sede2").val("");
    $('#foto-condominio1').attr('src',"/img/home.png")+ '?' + Math.random();
    $('#foto-condominio2').attr('src',"/img/home.png")+ '?' + Math.random();
    $('#foto-condominio3').attr('src',"/img/home.png")+ '?' + Math.random();
}
var pintarDatosActualizar= function(data){
    $('#divTabla').hide();
    $('#divForm').show();
	$('.divCam').show();
    if(data.id_sede!=null){$("#id_sede").val(data.id_sede);}
    if(data.id_sede!=null){$("#id_sede2").val(data.id_sede);}
    if(data.des_sede!=null){$("#des_sede").val(data.des_sede);}
    if(data.id_ciudad!=null){$("#id_ciudad").val(data.id_ciudad).trigger("change");}
    if(data.id_comuna!=null){$("#id_comuna").val(data.id_comuna).trigger("change");}
    if(data.direccion!=null){$("#direccion").val(data.direccion);}
    if(data.obs!=null){$("#obs").val(data.obs);}
    if(data.telefonos!=null){
        var res = data.telefonos.split("-");
        $("#paist").val(res[0]);
        $("#codigot").val(res[1]);
        $("#numerot").val(res[2]);
    }
    if(!data.activo_sede){
        $("#activo_sede").prop("checked",false);
    }else{
        $("#activo_sede").prop("checked",true);
    }
    // if(data.activo_sede='false'){$("#activo_sede").prop("checked", false);}
    if(data.foto1!=null){if (data.foto1.length>3){$('#foto-condominio1').attr('src',data.foto1)+ '?' + Math.random();}}
    if(data.foto2!=null){if (data.foto2.length>3){$('#foto-condominio2').attr('src',data.foto2)+ '?' + Math.random();}}
    if(data.foto3!=null){if (data.foto3.length>3){$('#foto-condominio3').attr('src',data.foto3)+ '?' + Math.random();}}
    $("#cancelar").html(" Volver");
}

var eliminarFotoC = function(){
    var id_sede=$('#id_sede2').val();
    parametroAjax.ruta=rutaE;
    parametroAjax.data= {id_sede:id_sede};
    respuesta=procesarajax(parametroAjax);
    ManejoRespuesta(respuesta);
}

var actualizarFotos = function(){
    var formu=$(this);
    var nombreform=$(this).attr("id");
    if(nombreform=="FormFotos" ){ var divresul="notificacion_resul_fci"}
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
		                if(res.foto1!=null){if (res.foto1.length>3){$('#foto-condominio1').attr('src',res.foto1)+ '?' + Math.random();}}
					    if(res.foto2!=null){if (res.foto2.length>3){$('#foto-condominio2').attr('src',res.foto2)+ '?' + Math.random();}}
					    if(res.foto3!=null){if (res.foto3.length>3){$('#foto-condominio3').attr('src',res.foto3)+ '?' + Math.random();}}
				        limpiarTabla();
                        cargarTablaSedes(res.v_sedes);
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
var validarC=function(){$('#FormCondominio').formValidation('validate');};
var limpiarTabla = function(){destruirTablaS('tablaSedes');};
var cargarFotos = function(){$('#divFotos').window('open');}
$(document).ready(function(){
	$("#tituloPantalla").text(d['title']);
	cargarTablaSedes(d.v_sedes);
	crearallcombos();
    $(document).on('click','#guardar',validarC);
    $(document).on('click','#agregar',cargarForm);
    $(document).on('click','#cancelar',cargarTabla);
    $(document).on('click','#guardarF',cargarFotos);
    $(document).on('click','#cargar',actualizarFotos);
    $(document).on('click','#eliminar',eliminarFotoC);
    var tableB = $('#tablaSedes').dataTable();
    $('#tablaSedes tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        Registrocondominio = TablaTraerCampo('tablaSedes',this);
    });
    tableB.on('dblclick', 'tr', function () {
        $('#close').trigger('click');
    });
     $(function() {
        $.contextMenu({
            selector: '#tablaSedes',
            callback: function(key, options) {
                switch(key) {
                    case "1":
                        pintarDatosActualizar(Registrocondominio);
                        break;
                }
            },
            items: {
                "1": {name: "Editar", icon: "edit"},
            }
        });
    });

    $('#FormCondominio').formValidation({
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'des_sede': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
           'id_ciudad': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'id_comuna': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'paist': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'codigot': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'numerot': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'fondo_reserva': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'fecha_facturacion': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'direccion': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
        }
    }).on('success.form.fv', function(e){
        Procesarcondominio();
    }).on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});
