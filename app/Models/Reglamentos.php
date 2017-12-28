<?php
namespace app\Models;
use Illuminate\Database\Eloquent\Model;

use DB;
use Log;
use Auth;

class Reglamentos extends Model{  
   
   public function registrarR($data){
        $sql="select f_registro_reglamento('".$data."');";
        $result=DB::select($sql);
        return $result;
    }
    public function listReglamentos($id_sede){
        $sql="select * from v_reglamentos where estatus='t' and id_sede=".$id_sede.";";
        $result=DB::select($sql);
        return $result;
    }
    public function listTipo(){
        $sql="select * from v_reglamentos_combo;";
        $result=DB::select($sql);
        return $result;
    }
}