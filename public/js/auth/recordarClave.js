$(document).ready(function(){
    $("#preguntasecreta").select2({
        placeholder: "Seleccione su pregunta secreta",
          allowClear: true,
    }).on('change', function(e){
        if ($('#preguntasecreta').val() > 0) {
            $data = {
                id: $('#preguntasecreta').val(),
                des: $("#preguntasecreta option:selected").text()
            };
            //convertir el objeto en json
            $('#txtPreguntaSecreta').val(JSON.stringify($data));
        }else{
            $('#txtPreguntaSecreta').val('');
        };
    });
    if ($('#txtPreguntaSecreta').val()){
        var datos = $('#txtPreguntaSecreta').val();
        //convertir de json a objeto
        datos = JSON.parse(datos);
        $("#preguntasecreta").val(datos.id).trigger("change");
    }
});