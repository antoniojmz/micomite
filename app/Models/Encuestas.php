<?php
namespace app\Models;
use Illuminate\Database\Eloquent\Model;

use DB;
use Crypt;
use Log;
use Auth;
use Hash;

class Encuestas extends Model {

    public function listEncuestas($id_sede){
        $result= DB::table('v_encuestas')->where('id_sede',$id_sede)->get();
        return $result;
    }

    public function listEncuestasActivas($id_sede){
        $result= DB::table('v_encuestas')->where('id_sede',$id_sede)->where('activo','t')->get();
    return $result;
    }

    public function regEncuesta($data){
        $sql="select f_registro_encuesta('".$data."');";
        $result=DB::select($sql);
        return $result;
    }

    public function listOpcion($id_encuesta){
        $result= DB::table('opciones')->where('id_encuesta',$id_encuesta)->where('activo','t')->get();
        return $result;
    }

    public function regOpcion($data){
        $sql="INSERT INTO opciones(id_encuesta,titulo)VALUES (".$data['id_encuesta2'].",'".$data['opcion']."');";
        $result=DB::select($sql);
        return $result;
    }
    public function delEncuesta($data){     
        $sql="UPDATE encuestas SET activo='f' WHERE id_encuesta=".$data['id_encuesta'].";";
        $result=DB::select($sql);
        return $result;
    }
    public function listResultados($id_encuesta){
        $result= DB::table('v_resultados')->where('id_encuesta',$id_encuesta)->get();
        return $result;
    }    
    public function listEpendientes($data){
        $sql="select f_consulta_encuesta('".$data."');";
        $result=DB::select($sql);    
        return $result;
    } 
    public function procesarVoto($data){
        $sql="select f_votar_encuesta('".$data."');";
        // Log::info($sql);
        $result=DB::select($sql);    
        return $result;
    }
}