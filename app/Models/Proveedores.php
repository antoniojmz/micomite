<?php
namespace app\Models;
use Illuminate\Database\Eloquent\Model;

use DB;
use Crypt;
use Log;
use Auth;
use Hash;


class Proveedores extends Model {

    public function listProveedores(){
        $result= DB::table('v_proveedores_admin')->get();
		return $result;
    }

    public function listProveedoresVotacion(){
        $result= DB::table('v_votacion_proveedores')->get();
        return $result;
    }

    public function listProveedoresActivo($id_sede){
        $result = DB::table('v_proveedores')->where([
            ['activo', '=', 'true'],
        ])->get();
        return $result;
    }

    public function listCategoria(){
        return DB::table('v_categorias')->pluck('text','id');
    }


    public function listCategoriasActivas(){
        $sql="select id_categoria as id, des_categoria as text from v_proveedores group by id_categoria, des_categoria;";
        $result=DB::select($sql);
        return $result;
    }

    public function regProveedor($data){
        $sql="select f_registro_proveedor('".$data."');";
        $result=DB::select($sql);
		return $result;
    }


    public function listComentariosProveedor($id_proveedor){

        $result = DB::table('v_votacion_comentarios_prov')->where([
            ['id_proveedor', '=', $id_proveedor],
        ])->get();

        return $result;
    }

    public function regVotacionProveedor($data){
        $sql="select f_registro_votacion_prov('".$data."');";
        $result=DB::select($sql);
        return $result;
    }

}