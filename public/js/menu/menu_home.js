var pintarDatos= function(data){
    if(data.des_nivel!=null){if(data.des_nivel=="Comit&eacute;"){$("#spanPerfil").text("Comit\u00E9");}else{$("#spanPerfil").text(data.des_nivel);}}
    if(data.name!=null){$("#spanNombre").text(data.name);}
    if(data.rut!=null){$("#spanRut").text(data.rut);}
    if(data.condominio!=null){$("#spanCondominio").text(data.condominio);}
    if(data.urlimage!=null){if (data.urlimage.length>3){$('#foto-perfil').attr('src',data.urlimage)+ '?' + Math.random();}}
    if(data.foto1!=null){if (data.foto1.length>3){$('#foto-condominio1').attr('url',data.foto1)+ '?' + Math.random();}}
}
function blink_uno() {
$("#Alert").show();
setTimeout('blink_dos()',800);
}
function blink_dos() {
$("#Alert").hide();
setTimeout('blink_uno()',800);
}
$(document).ready(function(){
    blink_uno();
    $('.popovers').popover();
    window.setTimeout(function() {
    $(".alert").fadeTo(10000, 500).slideUp(500, function(){
    $(this).remove();
    });
    // 500 : Time will remain on the screen
    }, 500);
    if(d.v_datos_incompletos.v_cambio_pass>0){
        $('#divAlert1').show();
        $('#spanTittle').text("Urgente: ");
        $('#spanMsj').text("Estimado propietario, para mayor seguridad le sugerimos cambiar su contraseña de acceso.");
    }
    if(d.v_datos_incompletos.v_datos_incompletos[0].count>0){
        $('#divAlert2').show();
        $('#spanTittle2').text("Urgente: ");
        $('#spanMsj2').text("Estimado propietario, le recomendamos completar su registro actualizando sus datos personales.");
    }
	pintarDatos(d);
    window.mySwipe = $('#mySwipe').Swipe({
        startSlide: 4,
        auto: 3000,
        continuous: true,
        disableScroll: true,
        stopPropagation: true,
        callback: function(index, element) {},
        transitionEnd: function(index, element) {}
    }).data('Swipe');
    var dd = $('.vticker').easyTicker({
        direction: 'down',
        easing: 'easeInOutBack',
        speed: 'slow',
        interval: 2000,
        height: 'auto',
        visible: 5,
        mousePause: 0,
        controls: {
            up: '.up',
            down: '.down',
            toggle: '.toggle',
            stopText: 'Stop !!!'
        }
    }).data('easyTicker');
});