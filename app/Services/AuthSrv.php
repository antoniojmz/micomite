<?php

namespace App\Http\Controllers\Auth;
namespace App\Services; 

// Facades
use Auth;
use Session;
use Log;

//Models
use App\Models\User;

class AuthSrv {
    // Accesos definidos por defecto del app
    private $val_acceso_default = [
        'getMenu', 'getClave', 'postClave', 'getCambioClave', 'postCambioClave', 'getActualizarps', 'postActualizarps',
        'getActDatos', 'postActDatos', 'postProcesarActDatos','getSalir',
        'getSalirActualizarps', 'getModificarps', 'postModificarps', 'postProcesarps','getActCuenta','postActCuenta'
    ];

    public function getUser(){
        return Session::get('user_portal.perfiles');
    }

    public function Usuario_Accesos($id){
        $model = new User();
        return Session::put(
            'user_portal',['perfiles' => $model->Acceso($id),
            'menu'  => [],
            'reportes'  => [],
            'ValidarAcceso'  => $this->val_acceso_default
        ]);     
    }

    public function Menu($id_usuario_acceso){
        $arrayAcum = Session::get('user_portal.perfiles');
        foreach($this->getUser() as $acceso => $menu){
            if ($menu['id_usuario_acceso'] == $id_usuario_acceso){
                Session::put('user_portal',['perfiles' => $arrayAcum,
                    'usuario'  => $menu,
                    'reportes'  => $menu['reportes'],
                    'ValidarAcceso'  => $this->BuscarAccesos($menu['menu'])
                ]);
                break;
            }
        }
    }

    public function BuscarAccesos($menu) {
        $val_acceso = '';
        foreach ($menu as $item) {
            if (array_key_exists('http', $item)){
                $val_acceso .= ','.$item['http'];
            }
        }
        $val_acceso = substr($val_acceso,1);
        $array = explode(",", $val_acceso);
        return $array;
    }

    public function ValidarAcceso(){
        if (Session::has('user_portal.ValidarAcceso')){
            $val_array = array_merge(
                Session::get('user_portal.ValidarAcceso'),
                $this->val_acceso_default
            );
            if ($this->NroAccesos() > 1)
                array_push($val_array, "getCambioAcceso", "postCambioAcceso");
            return $val_array;
        }else{
            return $this->val_acceso_default;
        }
    }

    public function Reportes() {
        return Session::get('user_portal.reportes');
    }

    Public function Menudefault(){
        return $this->Menu($this->getUser()[0]['id_usuario_acceso']);
    }

    public function MenuSeleccionado() {
        return Session::get('user_portal.usuario.menu');
    }

    public function RolReporte($id_reporte){
        foreach ($this->Reportes() as $item) {
            if ( $item['id_reporte'] ==  $id_reporte){
                return $item['poder'];
            }
        }
        return "";
    }

    public function RolPantalla($id_pantalla){
        foreach ($this->MenuSeleccionado() as $item) {
            if (array_key_exists('id_pantalla', $item)){
                if ($item['id_pantalla'] == $id_pantalla){
                    return $item['poder'];
                }
            }
        }
        return "";
    }

    public function DatosAccesoSeleccionado(){
        $arraydatos = [
            'usuario' => Auth::user()->username,
            'nombre' => Auth::user()->name,
            'telefono' => Auth::user()->telefono,
            'emailAlternativo' => Auth::user()->emailalternativo,
            'des_perfil' => Session::get('user_portal.usuario.des_nivel'),
            'id_estado' => Session::get('user_portal.usuario.id_estado'),
            'des_estado' => Session::get('user_portal.usuario.des_estado'),
            'id_sede' => Session::get('user_portal.usuario.id_sede'),
            'des_sede' => Session::get('user_portal.usuario.des_sede'),
            'id_usuario_acceso' => Session::get('user_portal.usuario.id_usuario_acceso'),
            'sede_nombre_corto' => Session::get('user_portal.usuario.nombre_corto')
        ];
        return $arraydatos;
    }

    public function NroAccesos(){
        // dd($this->getUser());
        // dd(Auth::user());
        return count($this->getUser());
    }

    public function Usuario_Noexiste(){
        // dd("Si entro a no existe");
        return Session::put('user_portal',['perfiles' => '',
            'menu'  => [],
            'reportes'  => [],
            'ValidarAcceso'  => $this->val_acceso_default
        ]);
    }
}