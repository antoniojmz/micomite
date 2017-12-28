<?php
namespace app\Models;
use Illuminate\Database\Eloquent\Model;

use DB;
use Log;
use Auth;


class Pagos extends Model {
    public function listTipoPagos(){
        return DB::table('v_tipo_pago_combos')->pluck('text','id');
    }

    public function listPagosPendientes($id_usuario, $id_sede){
        $result = DB::table('maestro_gcomunes')->where([
        ['id_sede', '=', $id_sede],
        ['id_usuario', '=', $id_usuario],
        ['estatus_periodo', '=', 'C'],
        ])->get();
        return $result;
    }

    public function listPagosPropietariosResumen($id_usuario, $id_sede){
        $sql="select * from v_resumen_saldos where id_sede =".$id_sede." and id_usuario=".$id_usuario.";";
        $result=DB::select($sql);
        return $result;
    }


    public function regPagoPropietario($data){

        $data=json_encode($data);
        $sql="select f_registro_pagos('".$data."');";
        $result['f_registro_pagos']=DB::select($sql);
        $var = $result['f_registro_pagos'][0]->f_registro_pagos;
        $var= explode('"', $var);
        $result['code']=$var[3];
        if ($result['code']==200){$result['id_pago_propietario']=$var[11];}
        return $result;
    }

    public function listPagosPropietarios($id_sede, $id_usuario){
        $sql="select * from v_validacion_pagos_p where id_sede =".$id_sede." and id_usuario=".$id_usuario." order by fecha_registro;";
        $result=DB::select($sql);
        return $result;
    }

    // public function BuscarCatalogoCombo($id_tipo_gasto){
    //     $sql="select id_concepto_detalle as id, descripcion as text from conceptos_detalles where id_tipo_padre=".$id_tipo_gasto.";";
    //     $result=DB::select($sql);
    //     return $result;
    // }

    // public function listGastos($id_sede){
    //     $result= DB::table('v_maestro_gastos')->where('id_sede',$id_sede)->get();
    //     return $result;
    // }

    // public function listApartamentos($id_sede){
    //     $result= DB::table('v_apto_propietarios_list')->where('id_sede',$id_sede)->get();
    //     return $result;
    // }

    // public function listConceptoPorTipo($id_sede){
    //     $result= DB::table('v_apto_propietarios_list')->where('id_sede',$id_sede)->get();
    //     return $result;
    // }

    // public function regCatalogo($data){
    //     $sql="select count(1) from conceptos_detalles where descripcion='".$data['descripcion']."'";
    //     $result=DB::select($sql);
    //     if ($result[0]->count>0){
    //         $result['f_registro']='{"code":"-2", "des_code":"Ya se encuentra registrado un concepto con la misma descricion"}';
    //         $result['v_catalogo']=[];
    //     }else{
    //         $sql="INSERT INTO conceptos_detalles(id_tipo_padre, id_sede, descripcion)VALUES(".$data['id_tipo_padre'].",".$data['id_sede'].",'".$data['descripcion']."');";
    //         DB::beginTransaction();
    //             $result=DB::select($sql);
    //         DB::commit();
    //         $sql="select id_concepto_detalle as id, descripcion as text from conceptos_detalles where id_tipo_padre=".$data['id_tipo_padre'].";";
    //         $result['v_catalogo']=DB::select($sql);
    //         $result['f_registro']='{"code":"200", "des_code":"Registrado correctamente"}';
    //     }
    //     return $result;
    // }
}