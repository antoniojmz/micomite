var RegistroUsuario = '';
var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};
var ManejoRespuesta = function(respuesta){
    if (respuesta.code=!'200'){
        mensajesAlerta('Error!','Contacte al personal informático', 'error');
        return 0;
    }else{
            if (respuesta.respuesta.code!='200'){
                mensajesAlerta('Error!',respuesta.respuesta.des_code, 'error');
                return 0;
            }else{
                mensajesAlerta('Procesado!',respuesta.respuesta.des_code, 'info');
                Boton_cancelar();
                return 0;
            }
    }
};
var Boton_cancelar = function(){
     $('#Formclave')[0].reset();
}
var cambiarClave = function(){
    parametroAjax.ruta=ruta;
    parametroAjax.data = $("#Formclave").serialize();
    respuesta=procesarajax(parametroAjax);
    ManejoRespuesta(respuesta);
};
var validador = function(){
 $('#Formclave').formValidation('validate');
};
var validar = function(){
    $('#Formclave').formValidation({
        excluded:[':disabled'],
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'password_old': {
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
                }
            },
        }
    })
    .on('success.form.fv', function(e){
        cambiarClave();
    })
    .on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
};
$(document).ready(function(){
    validar();
    $(document).on('click','#aceptar',validador);
});