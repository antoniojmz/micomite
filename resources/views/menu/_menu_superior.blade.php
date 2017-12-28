<!-- main nav -->
<!-- <nav class="navbar navbar-default navbar-fixed-top"> -->
  <!-- Una sangria grande -->
  <div>
  <!-- Sin sangria -->
  <!-- <div class="container-fluid"> -->
        <!-- nav header -->
        <div>
          <div class="navbar-header brand-logo">
            <table>
              <tr>
                <td>
                  <!-- <img id="img_logo" src="{{ asset('img/logo.png') }}" alt="App Logo" class="img-responsive" /> -->
                </td>
                <td>&nbsp;&nbsp;</td>
                <td>
                  <img src="{{ asset('img/menu.png') }}"><a href='javascript:void(0);' id='justify-icon' onclick="collapsar_menu()">
                  </a>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /nav header -->

        <!-- nav body -->
        <div class="collapse navbar-collapse" id="nav-main">
          <ul class="nav navbar-nav navbar-right">
              <li>
                <a href="{{ URL::route('consulta') }}">
                  <table><tr><td><img src="{{ asset('img/cambio.png') }}" alt="App Logo" class="img-responsive" /></td><td>&nbsp;Cambiar acceso</td></tr></table>
                </a>
              </li>
              <li class="visible-lg">
                <a onclick="toggleFullScreen()">
                  <table ><tr><td><img id="img_max" src="{{ asset('img/maximize.png') }}" alt="App Logo" class="img-responsive" /></td></tr></table>
                </a>
              </li>
              <li>
                <a onclick="toggle_east()">
                  <table><tr><td><img src="{{ asset('img/perfil.png') }}" alt="App Logo" class="img-responsive" /></td><td>&nbsp;Mi Perfil</td></tr></table>
                </a>
              </li>
              <li>
                <a href="{{ URL::route('consulta') }}">
                  <table><tr><td><img src="{{ asset('img/exit.png') }}" alt="App Logo" class="img-responsive" /></td><td>&nbsp;Salir</td></tr></table>
                </a>
              </li>
          </ul>
        </div>
        <!-- /nav body -->
  </div>
<!-- </nav> -->
<!-- /main nav