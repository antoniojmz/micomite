<?php
namespace app\Models;
use Illuminate\Database\Eloquent\Model;

use DB;
use Log;
use Auth;

class Apartamentos extends Model {

    public function listUsuariosAptos($data){
        $result= DB::table('v_propietarios_condominio')->where('id_sede',$data['id_sede'])->get();
        return $result;
    }

    public function listAptosUsuarios($data){
        $result= DB::table('v_apartamentos')->where('id_sede',$data['id_sede'])->where('id_usuario',$data['id_usuario'])->where('activo','t')->get();
        return $result;
    }

    public function regApartamento($data){
        $sql="select f_registro_apartamento('".$data."');";
        $result=DB::select($sql);
        return $result;
    }
    
    public function delApartamento($data){     
        $sql="UPDATE apartamentos SET activo='f' WHERE id_apartamento=".$data['id_apartamento'].";";
        $result=DB::select($sql);
        return $result;
    }

}