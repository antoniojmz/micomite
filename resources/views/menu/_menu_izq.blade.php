<nav style="color: #444;
  background: #fafafa;
  background-repeat: repeat-x;
  border: .5px solid #bbb;
  background: -webkit-linear-gradient(top,#ffffff 0,#eeeeee 100%);
  background: -moz-linear-gradient(top,#ffffff 0,#eeeeee 100%);
  background: -o-linear-gradient(top,#ffffff 0,#eeeeee 100%);
  background: linear-gradient(to bottom,#ffffff 0,#eeeeee 100%);
  background-repeat: repeat-x;padding:2px;">
  <div id='cssmenu'>
<!-- onclick="$('#panelPrincipal').layout('expand','west')" -->
    <div id="titlebar" style="padding:1px;">
    <!-- <a href="javascript:void(0)" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-avisoMenu'"><b>MENÚ</b></a> -->
    <ul class="menuList">
      @foreach($perfil->MenuSeleccionado() as $item)
        @if ($var_icon = $item['icon']) @endif
        @if (array_key_exists('heading', $item))
          <li>
            @include('menu._menu_item_void')
          </li>
        @else
          @if (array_key_exists('submenu', $item))
              <li class='has-sub'>
                @include('menu._menu_item_void')
                <ul class="menuList"><div style='border:1px solid #eee;background:#fff;'><div id='nombre_seccion' style='display:none;'><strong><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>{{$item['text']}}</span></strong><br><br></div>
                  @foreach($item['submenu'] as $subitem)
                    @if ($var_http = $subitem['sref']) @endif
                    <li>
                      <a href='javascript:void(0);'>
                        @include('menu._menu_item_icono')
                        <span>{{$subitem['text']}}</span>
                      </a>
                    </li>
                  @endforeach
                </ul>
              </li>
          @else
            <li id="@php  echo $item['sref']; @endphp">
                @if ($var_http = $item['sref']) @endif
                @include('menu._menu_item_http')
            </li>
          @endif
        @endif
      @endforeach
    </ul>
  </div>
</nav>