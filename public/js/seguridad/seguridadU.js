var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var GuardarVotacion = function(){
    parametroAjax.data = $("#FormVotacion").serialize();
    parametroAjax.ruta=rutaV;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesar(respuesta);
};

var mostrarVotacion = function(){
    var valor_id = $(this).attr("value");
     parametroAjax.data = {'id_seguridad': valor_id };
     parametroAjax.ruta=rutaC;
     respuesta=procesarajax(parametroAjax);
     verComentariosModal(respuesta);

};

var verComentariosModal = function(respuesta){
    switch(respuesta.code){
      case '200':
          abrirModalComentarios(respuesta);
          break;
      default:
         mensajesAlerta('Error','Se ha encontrado un error comunicarse con el personal informático', 'error');
  }
};

var capturaComentario = function(){
   var com = $(this).val();
   $('.comentarios').val(com);
};

var abrirModalComentarios = function(respuesta){
    $("#divComentarios").empty();
    $("#tituloSeguridad").text('');
    $('#myModalComentarios').window('open');
    var objeto = respuesta.respuesta;
    var contenedor = $("#divComentarios");
    $("#tituloSeguridad").text(objeto[0].seguridad);

    $(objeto).each(function(){ 
    var estrellas = this.votacion;
    var cadena = "";
    var rutaImagen = "/img/foto.jpeg";

    if(this.foto_usuario!=null){ rutaImagen = this.foto_usuario}

    for (var i = 0; i < 5; i++) {
        if(i < estrellas){
          cadena += "<a href='#'>&#9733;</a>";
        }else{
          cadena += "<a href='#' style='color: #95a5a6;display: inline-block; font-size: 23px;' >&#9733;</a>";
        }
    }
        $(contenedor).append('<div class="row"><div class="col-md-12 fichaComentario"><table width="100%" border="0"><tr><td colspan="2" width="40%"><h3><b><center>'+ this.des_sede +'</center></b></h3></td><td rowspan="2" width="60%">'+ this.comentario +'</td></tr><tr><td><br><img src="'+ rutaImagen +'" class="img-circle" width="60"></td><td><br><table class="table" width="100%" border="0"><tr></tr><tr><h4>' + this.usuario + '</h4></tr><tr>Fecha: <i>'+  this.fecha_publicacion   +'</i></tr><tr></tr><tr><div><div class="star-rating">' + cadena +'</div></div></tr></table></td></tr></table></div></div><br>');
    });

};


var ManejoRespuestaProcesar = function(respuesta){

  switch(respuesta.code){
      case '200':
          $('.cerrar').modal('hide');
          $('.comentarios').val('');
          $('.id_seguridad').val('');
          mensajesAlerta('Procesado!','Registro éxitoso', 'info');
          location.reload();
          break;
      default:
         mensajesAlerta('Error','Se ha encontrado un error comunicarse con el personal informático', 'error');
  }
};



// Starrr plugin (https://github.com/dobtco/starrr)
var __slice = [].slice;

(function($, window) {
  var Starrr;

  Starrr = (function() {
    Starrr.prototype.defaults = {
      rating: void 0,
      numStars: 5,
      change: function(e, value) {}
    };

    function Starrr($el, options) {
      var i, _, _ref,
        _this = this;

      this.options = $.extend({}, this.defaults, options);
      this.$el = $el;
      _ref = this.defaults;
      for (i in _ref) {
        _ = _ref[i];
        if (this.$el.data(i) != null) {
          this.options[i] = this.$el.data(i);
        }
      }

      this.createStars();
      this.syncRating();
      this.$el.on('mouseover.starrr', 'span', function(e) {
        return _this.syncRating(_this.$el.find('span').index(e.currentTarget) + 1);
      });
      this.$el.on('mouseout.starrr', function() {
        return _this.syncRating();
      });
      this.$el.on('click.starrr', 'span', function(e) {
        return _this.setRating(_this.$el.find('span').index(e.currentTarget) + 1);
      });
      this.$el.on('starrr:change', this.options.change);
    }

    Starrr.prototype.createStars = function() {
      var _i, _ref, _results;

      _results = [];
      for (_i = 1, _ref = this.options.numStars; 1 <= _ref ? _i <= _ref : _i >= _ref; 1 <= _ref ? _i++ : _i--) {
        _results.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"));
      }
      return _results;
    };

    Starrr.prototype.setRating = function(rating) {

      $('.estrellas').val(rating);

      $("#count").text(rating);
      if (this.options.rating === rating) {
        rating = void 0;
      }
      this.options.rating = rating;
      this.syncRating();
      return this.$el.trigger('starrr:change', rating);
    };

    Starrr.prototype.syncRating = function(rating) {
      var i, _i, _j, _ref;


      rating || (rating = this.options.rating);
      if (rating) {
        for (i = _i = 0, _ref = rating - 1; 0 <= _ref ? _i <= _ref : _i >= _ref; i = 0 <= _ref ? ++_i : --_i) {
          this.$el.find('span').eq(i).removeClass('glyphicon-star-empty').addClass('glyphicon-star');
        }
      }
      if (rating && rating < 5) {
        for (i = _j = rating; rating <= 4 ? _j <= 4 : _j >= 4; i = rating <= 4 ? ++_j : --_j) {
          this.$el.find('span').eq(i).removeClass('glyphicon-star').addClass('glyphicon-star-empty');
        }
      }
      if (!rating) {
        return this.$el.find('span').removeClass('glyphicon-star').addClass('glyphicon-star-empty');
      }
    };

    return Starrr;

  })();
  return $.fn.extend({
    starrr: function() {
      var args, option;

      option = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
      return this.each(function() {
        var data;

        data = $(this).data('star-rating');
        if (!data) {
          $(this).data('star-rating', (data = new Starrr($(this), option)));
        }
        if (typeof option === 'string') {
          return data[option].apply(data, args);
        }
      });
    }
  });
})(window.jQuery, window);

$(function() {
  return $(".starrr").starrr();
});

var asignarSeguridadId= function(){
   var com = $(this).val();
   $('.id_seguridad').val(com);
};


var validarVotacion=function(){$('#FormVotacion').formValidation('validate');};

$(document).ready(function(){

    $(document).on('click','#guardarV',validarVotacion);
    $(document).on('click','.parametro',asignarSeguridadId);
    $(document).on('click','.evaluaciones',mostrarVotacion);

    $('#FormVotacion').formValidation({
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'comentarios': {
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

     GuardarVotacion();
  })
  .on('status.field.fv', function(e, data){
      data.element.parents('.form-group').removeClass('has-success');
  });



});

