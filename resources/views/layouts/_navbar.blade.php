<!-- main nav -->
<nav class="navbar navbar-default navbar-fixed-top">
  <!-- Una sangria grande -->
  <div class="container">
  <!-- Sin sangria -->
  <!-- <div class="container-fluid"> -->
    <!-- nav header -->
    <div>
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-main" aria-expanded="false">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ URL::route('home') }}">{{ $app_name_project }}</a>
      </div>
    </div>
    <!-- /nav header -->

    <!-- nav body -->
    <div class="collapse navbar-collapse" id="nav-main">
      <ul class="nav navbar-nav navbar-right">
        <!-- Login -->
        <li><a href="{{ URL::route('login') }}">{{ Lang::get('navbar.login_btn') }}</a></li>
        <!-- Crear cuenta (buscar) -->
        <li><a class="navbar-btn btn btn-primary" href="{{ URL::route('buscar') }}">{{ Lang::get('navbar.signup_btn') }}</a></li>
      </ul>
    </div>
    <!-- /nav body -->
  </div>
</nav>
<!-- /main nav