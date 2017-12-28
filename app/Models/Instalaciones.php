<?php
namespace app\Models;
use Illuminate\Database\Eloquent\Model;

use DB;
use Log;
use Auth;

class Instalaciones extends Model{  
   
   public function registrarI($data){
        $data=json_encode($data);
        $sql="select f_registro_instalacion('".$data."');";
        $result=DB::select($sql);
        return $result;
    }

    public function listInstalacionesCombos(){
        $result= DB::table('v_instalaciones_combo')->get();
        return $result;
    }

    public function listInstalaciones($id_sede){
        $sql="select * from v_instalaciones where id_sede=".$id_sede.";";
        $result=DB::select($sql);
        return $result;
    }
}