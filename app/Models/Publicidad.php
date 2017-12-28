<?php
namespace app\Models;
use Illuminate\Database\Eloquent\Model;

use DB;
use Crypt;
use Log;
use Auth;
use Hash;

class Publicidad extends Model{
    public function listComunas(){ 
        return DB::table('v_comunas')->pluck('des_comuna','id_comuna');
    }
    
    public function listPublicidadAdmin(){
        $result= DB::table('v_publicidad_admin')->get();
        return $result;
    }     
    public function listPublicidad(){
        $result= DB::table('v_publicidad')->get();
		return $result;
    } 
    public function listPublicidadActivas($id_sede){
        $id_comuna = DB::table('v_sedes')->where('id_sede',$id_sede)->where('activo_sede','t')->value('id_comuna');
        $result= DB::table('v_publicidad')->where('id_comuna',$id_comuna)->where('activo','t')->get();
		return $result;
    }
    public function regPublicidad($data){
        $sql="select f_registro_publicidad('".$data."');";
        $result=DB::select($sql);
		return $result;
    }
}