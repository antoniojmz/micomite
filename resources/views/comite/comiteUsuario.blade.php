@extends ('menu.plantilla_menu')
@section ('body')
<div class="container box box-purple" id="content">
        <center>
         <div class="col-md-12">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <h2 id="spanTitulo" class="borderTitulo">Integrantes del Comité</h2>
                </div>
                <div class="col-md-4"></div>
          </div>
        </center>


        @foreach ($v_comites as $com)
            <div class="col-md-3">
                 <div class="card"><br><center>

                    <?php
                        $var_icon = '/img/foto.jpeg';
                        if (strlen($com->urlimage)>3)
                            $var_icon = $com->urlimage;
                    ?>

                    <input type="hidden" id="image" name="image">
                    <div>
                        <img name="foto-perfil" id="foto-perfil" class="foto-perfil block-center img-thumbnail" width="150" height="150" alt="Image" src='{!! asset("$var_icon") !!}'>
                    </div>

                    <div class="contenido">
                        <h2><b>{{ $com->name }}</b></h2>

                        <p>Cargo: <b>{{ $com->cargo }}</b></p>
                        <p>{{ $com->email }}</p>
                        <p>Teléfonos:{{ $com->telefonoresidencial }}</p>
                        <p>{{ $com->movil }}</p>
                    </div>
                </center></div>
            </div>
        @endforeach
</div>
<style>
    .card {
        /* Add shadows to create the "card" effect */
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        margin-top: 40px;
    }

    /* On mouse-over, add a deeper shadow */
    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    /* Add some padding inside the card container */
    .contenido {
        padding: 2px 16px;
        color: #6E6E6E;
        height: 150px;

    }
</style>

<script Language="Javascript">
  var d = [];
  d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
  d['v_encuestas']= JSON.parse(rhtmlspecialchars('{{ $v_encuestas }}'));
  d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
  d['id_nivel'] = rhtmlspecialchars('{{ $id_nivel }}');
</script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection
