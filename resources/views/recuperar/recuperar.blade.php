<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Recuperar de contraseña</title>
        <link rel="stylesheet" href="{{ asset('css/font-awesome-4.5.0/css/font-awesome.min.css') }}">
        <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('waitme/waitMe.min.css') }}" rel="stylesheet" type="text/css" /> 
        <link href="{{ asset('css/login/login.min.css') }}" rel="stylesheet" type="text/css" /> 
<!--         <style type="text/css">
            input:invalid {
            border: 1px solid red;
            }
            /* Estilo por defecto */
            input:valid {
                border: 1px solid blue;
            }
            /* Estilo por defecto */
            input:required:invalid {
                border: 1px solid red;
            }
            input:required:valid {
                border: 1px solid blue;
            }
        </style> -->
    </head>
    <body>
        <div class="container" id="content">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-6">
                    <br />
                    <div class="box box-info">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-3"></div>
                                <div class="col-md-8">
                                    <h3>Recuperar contraseña</h3>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="col-md-12">
                                {!! Form::open(['id'=>'Formrecuperar',
                                'autocomplete' => 'off']) !!}
                                    <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
                                    {!! csrf_field() !!}
                                    <br>
                                    <div id="divRespuesta">
                                        <b><span id="spanRespuesta" style="font-size:15px;"></span></b>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Email o RUT(XXXXXXX-X):</label>
                                        <div class="col-md-5">
                                            {!! Form::text('recuperar', '', [
                                            'id'            => 'recuperar',
                                            'class'         => 'form-control vtObs2',
                                            'placeholder'   => 'Ingrese su email o RUT',
                                            'style'         => 'width:100%;height:35px',
                                            'maxlength'     => '50'])!!}
                                        </div>
                                    </div>
                                    <br />
                                    <div class="col-md-4"></div>
                                    <div class="col-md-6">
                                        <br><button id="enviar" type="button" class="btn btn-primary fa fa-check-circle"> Enviar</button>
                                    </div>
                                    <br /><br /><br />
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script Language="Javascript">
        var ruta = "{{ URL::route('recuperar') }}"
    </script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/auth/util.min.js') }}"></script>
    <script src="{{ asset('validator/valtexto.min.js') }}"></script>
    <script src="{{ asset('waitme/waitMe.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/recuperar/recuperar.min.js') }}"></script>
</html>