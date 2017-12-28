<?php
namespace app\Models;
use Illuminate\Database\Eloquent\Model;

use DB;
use Crypt; 
use Log;
use Auth;
use Hash;


class Gastos extends Model {
    public function listTipoPadre(){
        $result= DB::table('v_tipo_gastos_combos')->get();
        return $result;
    }

    public function searchPeriodo($id_sede){
        $result = DB::table('v_periodos_pago')->where([
        ['id_sede', '=', $id_sede],
        ['fecha_corte', '=', null],
        ])->value('id_periodo');
        return $result;
    }

    public function BuscarCatalogoCombo($id_tipo_gasto){
        $sql="select id_concepto_detalle as id, descripcion as text from conceptos_detalles where id_tipo_padre=".$id_tipo_gasto.";";
        $result=DB::select($sql);
        return $result;
    }


    public function listAnios($id_sede){
        $sql="select to_char(fecha_inicio, 'YYYY') as id, to_char(fecha_inicio, 'YYYY') as text from periodos_pago where id_sede=".$id_sede." group by to_char(fecha_inicio, 'YYYY')";
        $result=DB::select($sql);
        return $result;
    }

    public function confirmarPago($id_pago_propietario){
        $sql="update pagos_propietarios set estatus='C' where id_pago_propietario=".$id_pago_propietario.";";
        $result=DB::select($sql);
        return $result;
    }

    public function rechazarPago($id_pago_propietario){
        $sql="update pagos_propietarios set estatus='R' where id_pago_propietario=".$id_pago_propietario.";";
        $result=DB::select($sql);
        return $result;
    }

    public function listGastos($id_sede){
        $result = DB::table('v_pagos_comunes')->where([
        ['id_sede', '=', $id_sede]
        ])->get();
        return $result;
    }

    public function listGastosCons($id_sede){
        $result = DB::table('v_pagos_comunes')->where([
        ['id_sede', '=', $id_sede],
        ['estatus_periodo', '=', 'A'],
        ])->get();
        return $result;
    }

    public function buscarDatosPropietarios($id_pago_propietario, $id_sede){
        $result = DB::table('v_pagos_propietarios')->where([
        ['id_sede', '=', $id_sede],
        ['id_pago_propietario', '=', $id_pago_propietario]
        ])->get();
        return $result;
    }

    public function buscarPeriodoPago($id_sede){

        $result = DB::table('v_totales_mes')->where([
        ['id_sede', '=', $id_sede],
        ['mes_inicio', '=', 'C'],
        ])->get();
        return $result;
    }

    public function regCierreMes($data){
        $sql="select f_registro_cierre_mes('".$data."');";
        $result=DB::select($sql);
        return $result;
    }

    public function conGastosComunes($data){
        $sql="select f_consulta_gcomunes('".$data."');";
        $result=DB::select($sql);
        return $result;
    }


    public function listGastosComunesA($id_sede){
        $result = DB::table('v_pagos_adicionales')->where([
        ['id_sede', '=', $id_sede]
        ])->get();
        return $result;
    }

    public function listGastosComunesAV($id_sede){
        $result = DB::table('v_pagos_adicionales')->where([
        ['id_sede', '=', $id_sede],
        ['estatus_periodo', '=', 'A'],
        ])->get();
        return $result;
    }

   public function listGastosConsulta($id_periodo, $id_sede){

        $sql = "select * from v_pagos_comunes where id_sede = ".$id_sede." and id_periodo=". $id_periodo.";";
        $result=DB::select($sql);
        return $result;
    }

    public function listGastosComunesAConsulta($id_periodo, $id_sede){

        $sql = "select * from v_pagos_adicionales where id_sede = '".$id_sede."' and  id_periodo=".$id_periodo.";";

        $result=DB::select($sql);
        return $result;
    }

    public function listPeriodosGastosConsulta($arreglo){

        $id_sede = $arreglo['id_sede'];
        $mes = $arreglo['mes'];
        $anio = $arreglo['anio'];
        $id_apartamento =  $arreglo['id_apartamento'] ;

        $sql ="select * from v_totales_mes where mes_inicio = '".$mes."' and to_char(fecha_inicio::date, 'YYYY')='".$anio."' and id_sede=". $id_sede.";";

        $result=DB::select($sql);
        return $result;
    }

    public function listPeriodosGastos($id_sede){
        $result = DB::table('v_totales_mes')->where([
        ['id_sede', '=', $id_sede],
        ['estatus', '=', 'A'],
        ])->get();
        return $result;
    }

    public function listPagosPropietarios($id_sede){
        $result = DB::table('v_validacion_pagos_p')->where([
        ['id_sede', '=', $id_sede]
        ])->get();
        return $result;
    }

    public function listPagosPropietariosv($id_sede){
        $result = DB::table('v_validacion_pagos_p')->where([
        ['id_sede', '=', $id_sede],
        ['estatus', '=', 'A'],
        ])->get();
        return $result;
    }

    public function listGastosApartamento($id_sede){
        $result = DB::table('maestro_gcomunes')->where([
        ['id_sede', '=', $id_sede],
        ['estatus_periodo', '=', 'A'],
        ])->get();
        return $result;
    }

    public function listPropietariosCorreo($id_sede){
        $result = DB::table('v_correos_propietarios')->where([
        ['id_sede', '=', $id_sede]
        ])->get();
        return $result;
    }

    public function listGastosApartamentoConsulta($id_periodo, $id_sede, $id_apartamento){

        if($id_apartamento == null || $id_apartamento == '0'){
            $sql ="select * from maestro_gcomunes where id_sede=".$id_sede." and id_periodo='".$id_periodo."' order by numero;";
        }else{
            $sql ="select * from maestro_gcomunes where id_sede=".$id_sede." and id_periodo='".$id_periodo."' and id_apartamento=".$id_apartamento." order by numero;";
        }

        $result=DB::select($sql);
        return $result;
    }

    public function deleteGastosComunesA($id_pago_adicional){
        $sql = "DELETE FROM pagos_adicionales where id_pago_adicional =".$id_pago_adicional.";";
        $result=DB::select($sql);
        return '200';
    }

    public function deleteGastos($id_pago_gcomun){
        $sql = "DELETE FROM pagos_gcomunes where id_pago_gcomun =".$id_pago_gcomun.";";
        $result=DB::select($sql);
        return '200';
    }

    public function listApartamentos($id_sede){
        $result= DB::table('v_apto_propietarios_list')->where('id_sede',$id_sede)->get();
        return $result;
    }

    public function listApartamentosCbo($id_sede){
        $sql="select id_apartamento as id, numero as text from v_apto_propietarios_list where id_sede=".$id_sede." order by numero";
        $result=DB::select($sql);
        return $result;
    }

    public function listConceptoPorTipo($id_sede){
        $result= DB::table('v_apto_propietarios_list')->where('id_sede',$id_sede)->get();
        return $result;
    }

    public function regCatalogo($data){
        $sql="select count(1) from conceptos_detalles where descripcion='".$data['descripcion']."'";
        $result=DB::select($sql);
        if ($result[0]->count>0){
            $result['f_registro']='{"code":"-2", "des_code":"Ya se encuentra registrado un concepto con la misma descricion"}';
            $result['v_catalogo']=[];
        }else{
            $sql="INSERT INTO conceptos_detalles(id_tipo_padre, id_sede, descripcion)VALUES(".$data['id_tipo_padre'].",".$data['id_sede'].",'".$data['descripcion']."');";
            DB::beginTransaction();
                $result=DB::select($sql);
            DB::commit();
            $sql="select id_concepto_detalle as id, descripcion as text from conceptos_detalles where id_tipo_padre=".$data['id_tipo_padre'].";";
            $result['v_catalogo']=DB::select($sql);
            $result['f_registro']='{"code":"200", "des_code":"Registrado correctamente"}';
        }
        return $result;
    }

    public function consultarGastosComunes($data){
        $sql="select f_consulta_gcomunes('".$data."');";

        $result=DB::select($sql);
        return $result;
    }


    public function calcularGastosComunes($data){
        $sql="select f_calculo_gcomunes('".$data."');";
        $result=DB::select($sql);
        return $result;
    }

    public function regPagoAdicional($data){
        $sql="select f_registro_pagos_adicionales('".$data."');";
        $result=DB::select($sql);
        return $result;
    }

    public function regPago($data){
        $sql="select f_registro_pagos_comunes('".$data."');";
        $result=DB::select($sql);
        $var = $result[0]->f_registro_pagos_comunes;
        $var= explode('"', $var);
        $result['code']=$var[3];
        if ($result['code']==200){$result['id_pago_gcomun']=$var[11];}
        return $result;
    }

}