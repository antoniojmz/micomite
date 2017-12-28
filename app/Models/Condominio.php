<?php
namespace app\Models;
use Illuminate\Database\Eloquent\Model;

use DB;
use Log;
use Auth;

class Condominio extends Model {
    public function resgistrarC($data){
        $data= $data['datos'];
        $data=json_encode($data);
        $sql="select f_registro_condominio('".$data."');";
        $result=DB::select($sql);
        return $result;
    }

    public function listSedes(){
        $result= DB::table('v_sedes')->get();
        return $result;
    }
    public function listCiudad(){
        return DB::table('v_ciudades')->pluck('des_ciudad','id_ciudad');
    }
    public function listFotos($id_sede){
        $sql="select * from sedes where id_sede=".$id_sede.";";
        $result=DB::select($sql);
        return $result;
    }
}