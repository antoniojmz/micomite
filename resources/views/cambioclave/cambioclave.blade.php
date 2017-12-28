@inject('reportes', 'App\Services\AuthSrv')
@extends ('menu.plantilla_menu')
@section ('body')
<div class="container box box-primary" id="content">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-6">
            <br />
            <!-- <div class="panel panel-default"> -->
                    <div class="col-md-12">
                        <center><h2 id="spanTitulo" class="borderTitulo">Cambio de contraseña</h2></center>
                    </div>
                    <br />
                        <form class="form-horizontal" role="form" name="Formclave" id="Formclave">
                            <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
                            <div class="form-group">
                                <label class="col-md-5 control-label">Contraseña actual:</label>
                                <div class="col-md-5">
                                    <input type="password" class="form-control" id="password_old" name="password_old"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-5 control-label">Contraseña nueva:</label>
                                <div class="col-md-5">
                                    <input type="password" class="form-control" id="password" name="password"
                                    data-fv-different="true"
                                    data-fv-different-field="password_old" data-fv-different-message="Las contraseñas no pueden ser iguales" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-5 control-label">Confirme nueva contraseña:</label>
                                <div class="col-md-5">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" data-fv-identical="true"
                                    data-fv-identical-field="password" data-fv-identical-message="Las contraseñas no coinciden" />
                                </div>
                            </div>
                            <br />
                            <div class="col-md-3"></div>
                            <div class="col-md-7">
                                <button id="cancelar" type="reset" class="btn btn-primary fa fa-times-circle"> Cancelar</button>
                                <button id="aceptar" type="button" class="btn btn-primary fa fa-check-circle"> Aceptar</button>
                            </div>
                            <br /><br /><br />
                        </form>
                    </div>
            <!-- </div> -->
        </div>
    </div>
</div>
<script type="text/javascript">
    var ruta = "{{ URL::route('clave') }}"
</script>

<script src="/js/cambioClave/cambioClave.min.js"></script>
@endsection
