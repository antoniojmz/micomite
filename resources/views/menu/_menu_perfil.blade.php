<br>
<div class="text-center foto-perfil">
  <a href="javascript:;">
  @if ($var_icon = 'foto.jpeg') @endif
  <img src='{!! asset("img/$var_icon") !!} 'alt="Image" class="block-center img-thumbnail" width="130" height="130"/>&nbsp;
  <!-- class="img-thumbnail" alt="imagen thumbnail"> -->
  </a>
</div>
<br>
<div class="caption">
  <ul class="list-group datos-user">
    <!-- <li class="list-group-item"><b>Nombre:</b> {{ $perfil->DatosAccesoSeleccionado()['nombre'] }}</li> -->
    <li class="list-group-item"><b>Usuario:</b> {{ $perfil->DatosAccesoSeleccionado()['usuario'] }}</li>
    <li class="list-group-item"><b>Perfil:</b> {{ $perfil->DatosAccesoSeleccionado()['des_perfil'] }}</li>
    <!-- <li class="list-group-item"><b>Sede:</b> {{ $perfil->DatosAccesoSeleccionado()['des_sede'] }}</li> -->
    <!-- <li class="list-group-item"><b>Estado:</b> {{ $perfil->DatosAccesoSeleccionado()['des_estado'] }}</li> -->
    <!-- <li class="list-group-item"><b>Correo alternativo:</b> {{ $perfil->DatosAccesoSeleccionado()['emailAlternativo'] }}</li> -->

    <li class="list-group-item"><b>Teléfono:</b> {{ $perfil->DatosAccesoSeleccionado()['telefono'] }}</li>
    <li class="list-group-item">
      @if ($var_icon = 'act-datos.jpeg') @endif
      <a href="{{ URL::route('actdatos') }}" class="btn btn-default">
        <img src='{!! asset("img/$var_icon") !!} ' >&nbsp;
        Actualizar datos
      </a>
    </li>
    <li class="list-group-item">
      @if ($var_icon = 'act-pregunta-secreta.jpeg') @endif
      <a href="{{ URL::route('modificarps') }}" class="btn btn-default">
        <img src='{!! asset("img/$var_icon") !!} ' >&nbsp;
        Actualizar pregunta secreta
      </a>
    </li>

    <li class="list-group-item">
      @if ($var_icon = 'cambioclave.png') @endif
      <a href="{{ URL::route('cambio_clave') }}" class="btn btn-default">
        <img src='{!! asset("img/$var_icon") !!} ' >&nbsp;
        Cambiar contraseña
      </a>
    </li>
  </ul>
</div>
