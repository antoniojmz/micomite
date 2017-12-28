var RegitroUsuario='';
var caso=boton=0;
var ManejoRespuestaProcesar = function(respuesta){
    var respuesta2=JSON.parse(respuesta.f_actualizacion_usuario[0].f_actualizacion_usuario);
    if (respuesta2.code = '200'){
        mensajesAlerta('Procesado!',respuesta2.des_code, 'info');
    }else{
        mensajesAlerta('Error',respuesta2.des_code, 'error');
    };
}
var ManejoRespuestaProcesarComite = function(respuesta){
    switch(respuesta.resultado) {
        case '200':
            $('#myModal').modal('hide');
            $('#divParticipante').show();
            $('#modal').hide();
            $('#spanComite').text(' Es participante del Comité con el cargo: ' + respuesta.cargo);
            mensajesAlerta('Procesado!','Registro éxitoso', 'info');
            $('#cargo').val("");
            boton=1;
            break;
        case '300':
            $('#spanComite').text('');
            $('#myModal').modal('hide');
            $('#modal').show();
            $('#divParticipante').hide();
            mensajesAlerta('Procesado!','Procesado éxitosamente', 'info');
            boton=2;
            break;
        default:
           mensajesAlerta('Error','Se ha encontrado un error comunicarse con el personal informático', 'error');
    };
}

var cargarFormularioC= function(data){
    caso=3;
    $("#spanTitulo").text("Cambio de clave");
    $('#divForm').show();
    $("#user_id").val(data.user_id);
    $('.caja-foto').hide();
    $('.noCambia').hide();
    $('.siCambia').show();
    $('.botonera').show();

}
var cargarFormulario= function(){
    caso=2;
    $('#divForm').show();
}
var pintarDatosActualizar= function(data,condominio){
     if (condominio!=null){
        $("#spanCondominio").text(condominio);
    }
    if (data.urlimage!=null){
        if (data.urlimage.length>1){
            $('.foto-perfil').attr('src',data.urlimage)+ '?' + Math.random();
            $("#image").val(data.urlimage);
        }
    }
    $("#spanTitulo").text("Actualización de datos");
    $("#user_id").val(data.user_id);
    if(data.rut!=null){$("#rut").val(data.rut);}
    if(data.direccion!=null){$("#direccion").val(data.direccion);}
    if(data.name!=null){$("#name").val(data.name);}
    if(data.email!=null){$("#email").val(data.email);}
    if(data.sexo!=null){
        if(data.sexo=='f'){
            $(".sexof").attr('checked', true);
            $(".sexom").attr('checked', false);
        }else{
            $(".sexom").attr('checked', true);
            $(".sexof").attr('checked', false);
        }
    }

    if(data.telefonoresidencial!=null){
        var res = data.telefonoresidencial.split("-");
        $("#paist").val(res[0]);
        $("#codigot").val(res[1]);
        $("#numerot").val(res[2]);
    }
    if(data.movil!=null){
        var res = data.movil.split("-");
        $("#paism").val(res[0]);
        $("#codigom").val(res[1]);
        $("#numerom").val(res[2]);
    }
    if(data.fecha_nacimiento!=null){
        $("#fecha_nacimiento").val(moment(data.fecha_nacimiento).format('DD/MM/YYYY'));
    }
    $(".siCambia").hide();
    $(".noCambia").show();
    $(".botonera").show();
    $(".caja-foto").show();
}
var Boton_cancelar = function(){
    caso=0;
    $('.foto-perfil').attr('src','/img/foto.png')+ '?' + Math.random();
    $("#spanTitulo").text("");
    $('#divForm').hide();
    $('#FormUsuario')[0].reset();
    $("#user_id").val("");
    $(".botonera").hide();
}
var Boton_agregar = function(){
    cargarFormulario();
    $("#spanTitulo").text('Registro de usuario');
    $("#user_id").val("");
    $('#FormUsuario')[0].reset();
    $(".caja-foto").hide();
    $(".siCambia").show();
    $(".noCambia").show();
    $(".botonera").show();
}

var eliminarFoto = function(){
        $.ajax({
            url: rutaE,
            headers: {'X-CSRF-TOKEN': $('#_token').val()},
            type:'POST',
             data: {'user_id':$('#user_id').val(), 'urlimage':$("#image").val()},
            async:false,
            dataType: 'JSON',
        })
        .done(function(d){
            $('.foto-perfil').attr('src','/img/foto.png')+ '?' + Math.random();
        });
}
var actualizarFoto = function(){
    var formu=$(this);
    var nombreform=$(this).attr("id");
    if(nombreform=="FormUsuario" ){
        var divresul="notificacion_resul_fci"
    }
        var form = $('#FormUsuario').get(0);
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
              if (data=='-2'){
                alert("Debe agregar una foto");
              }else{
                $('.foto-perfil').attr('src',data)+ '?' + Math.random();
              }
            },
            //si ha ocurrido un error
            error: function(data){
               alert("ha ocurrido un error al cargar su foto");
            },
        });
};
var ProcesarUsuario = function(){
        var user_id=$('#user_id').val();
        var rut= $('#rut').val();
        var name= $('#name').val();
        var email= $('#email').val();
        var direccion= $('#direccion').val();
        var telefonoresidencial= $('#paist').val()+"-"+$('#codigot').val()+"-"+$('#numerot').val();
        var movil= $('#paism').val()+"-"+$('#codigom').val()+"-"+$('#numerom').val();
        var fecha_nacimiento= $('#fecha_nacimiento').val();
        var sexo=$('input[name=sexo]:checked').val();
        datos=[];
        datos = {
            user_id:user_id,
            rut:rut,
            name: name,
            email: email,
            direccion: direccion,
            telefonoresidencial: telefonoresidencial,
            movil: movil,
            fecha_nacimiento: fecha_nacimiento,
            sexo: sexo
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
var ProcesarComite = function(){
        var user_id=$('#user_id').val();
        var cargo= $('#cargo').val();
        boton= boton;
        datos=[];
        datos = {
            user_id:user_id,
            cargo: cargo,
            boton: boton
        };
        $.ajax({
            url: rutaC,
            headers: {'X-CSRF-TOKEN': $('#_token').val()},
            type:'POST',
            async:false,
            dataType: 'JSON',
            data: {
                'datos':datos
            },
        })
        .done(function(d){
            ManejoRespuestaProcesarComite(d);
        });
};
var mostrarCal = function (){$("#fecha_nacimiento").focus();};
var validarU=function(){$('#FormUsuario').formValidation('validate');};
var validarC=function(){$('#FormComite').formValidation('validate');};
$(document).ready(function(){
    var fecha_n = $('#fecha_nacimiento').datetimepicker();
    $(document).on('click','.cal',mostrarCal);
    if(d['id_nivel']>2 && d['comite'].length>3){
        $('#divConsulta').show();
        $('#spanConsulta').text('Es participante del Comité con el cargo: ' + d['comite']);
    }
    if(d['comite'].length>3){
        boton=1;
        $('#divParticipante').show();
        $('#modal').hide();
        $('#spanComite').text('Es participante del Comité con el cargo: ' + d['comite']);
    }else{
        boton=2;
        $('#divParticipante').hide();
        $('#modal').show();
    }
    pintarDatosActualizar(d['v_datos'][0],d['condominio']);
    $(document).on('click','#guardar',validarU);
    $(document).on('click','#cancelar',Boton_cancelar);
    $(document).on('click','#agregar',Boton_agregar);
    $(document).on('click','#cargar',actualizarFoto);
    $(document).on('click','#eliminar',eliminarFoto);
    $(document).on('click','#guardarC',validarC);
  $('#FormUsuario').formValidation({
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'cedula': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'name': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'email': {
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido.'
                        },
                        emailAddress: {
                            message: 'Ingrese una dirección de correo valida'
                        }
                    }
                },
            'username': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'password': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'password_confirmation': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                    identical: {
                        field: 'password',
                        message: 'La contraseña debe coincidir.'
                    },
                }
            },
        }
    }).on('success.form.fv', function(e){
        ProcesarUsuario();
    }).on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });



  $('#FormComite').formValidation({
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'cargo': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
        }
    }).on('success.form.fv', function(e){
        ProcesarComite();
    }).on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });

});