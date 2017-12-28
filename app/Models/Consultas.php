<?php
namespace app\Models;

use Illuminate\Database\Eloquent\Model;

use DB;
use Log;
use Auth;

class Consultas extends Model {
	protected $table = "usuarios";
	protected $primaryKey='user_id';
	public $timestamps=false;
    public function listReportes($id_usuario_acceso){
        $sql="select id, text from v_reportes_combo where id_usuario_acceso='$id_usuario_acceso' order by id";
        $result= DB::select($sql);
        return $result;
    }
    public function proConsulta($data,$dats){
        $data= $data;
        $dats=$dats;
        $id_reporte=$data['Selectconsulta'];
        $sql = DB::select("SELECT alias FROM tablas WHERE rel_tabla = 32 AND activo_tabla = true AND cod_tabla='".$id_reporte."'");
        $sql=$sql[0]->alias;
        // Log::info($sql);
        $variables = array(
          'fecha_i' =>"'".$data['f_desde']."'",
          'fecha_f' =>"'".$data['f_hasta']."'",
          'id_sede'=>$dats['user_portal']['usuario']['id_sede'],
          'id_tribunal'=>$dats['user_portal']['usuario']['id_tribunal'],
          'user_id'=>Auth::User()->user_id,
        );
        $sql = preg_replace_callback('/{{([a-zA-Z0-9\_\-]*?)}}/i',
          function($match) use ($variables) {
            return  $variables[$match[1]];
        },$sql);
        $result= DB::select($sql);
        return $result;
    }
}