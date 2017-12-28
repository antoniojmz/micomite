<?php
namespace app\Models;
use Illuminate\Database\Eloquent\Model;

use DB;
use Crypt;
use Log;
use Auth;
use Hash;


class Seguridad extends Model {
    public function listSeguridad($id_sede){
        $result= DB::table('v_seguridad')->where('id_sede',$id_sede)->get();
		return $result;
    }
    public function listTurno($id_sede){
        $result= DB::table('v_turnos')->where('id_sede',$id_sede)->get();
        return $result;
    }
   public function listDias(){
        $result= DB::table('v_dias')->get();
        return $result;
    }
   public function listTipo(){
        $result= DB::table('v_tipo_seguridad')->get();
        return $result;
    } 
    public function consultarE($rutE){
        $result= DB::table('v_usuarios')->where('rut',$rutE)->get();
        return $result;
    } 
    public function listSeguridadActivo($id_sede){
        $result = DB::table('v_seguridad')->where([
            ['id_sede', '=', $id_sede],
            ['activo', '=', 'true'],
        ])->get();
        return $result;
    }

    public function listSeguridadVotacion($id_sede){
        $result = DB::table('v_votacion_seguridad')->where([
            ['id_sede', '=', $id_sede],
            ['activo', '=', 'true'],
        ])->get();
        return $result;
    }

    public function regSeguridad($data){
        $sql="select f_registro_seguridad('".$data."');";
        $result=DB::select($sql);
		return $result;
    }
    
    public function regTurno($data){
        $id_sede= $data['id_sede'];
        switch ($data['caso']){
            case 1:
                // Agregar turno
                $des_tabla = $data['horaI']." -- ".$data['horaF'];
                $sql="select  max(cod_tabla) from tablas t where t.rel_tabla = 333 and sede=".$id_sede.";";
                $max=DB::select($sql);
                $id=$max[0]->max+1;
                $sql="INSERT INTO tablas(des_tabla, cod_tabla, rel_tabla, sede, orden)VALUES('".$des_tabla."',".$id.",333,".$id_sede.",".$id.");";
              break;
            case 2:
                // Eliminar turno 
                $sql="UPDATE tablas SET activo_tabla='f' WHERE rel_tabla=333 and cod_tabla=".$data['cod_tabla']." and sede=".$id_sede.";";
              break;
        }
        DB::beginTransaction();
            $result=DB::select($sql);
        DB::commit();
    }


    public function regVotacionProveedor($data){
        $sql="select f_registro_votacion_seg('".$data."');";
        $result=DB::select($sql);
        return $result;
    }


    public function listComentariosSeguridad($id_seguridad){

        $result = DB::table('v_votacion_comentarios_seg')->where([
            ['id_seguridad', '=', $id_seguridad],
        ])->get();

        return $result;
    }

}