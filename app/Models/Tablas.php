<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

// Facades
use Hash;
use Log;
use Crypt;
use DB;

class Tablas extends Model implements AuthenticatableContract {

    use Authenticatable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tablas';

    /**
     * The primary key table used by the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_tabla';

    /**
     *
     * Disable the fields for defects
     *
     * @var boolean
     */
     public $timestamps = false;

    /**
     *
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['des_tabla', 'cod_tabla', 'rel_tabla', 'sede', 'orden', 'activo_tabla', 'alias'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    public function TablaFe(){
        $inssql = "select * from presentacion_fe_vida";
    return DB::select($inssql);

    }

    public function ComboTipoSolicitud(){
        return DB::table('v_tipo_solicitud')->lists('des_tipo_solicitud','id_tipo_solicitud');
    }

    public function TablaPreguntas(){
           $inssql = "select * from v_preguntas;";

    return DB::select($inssql);
    }

    public function TablaRespuestas(){
           $inssql = "Select * from fnc_pregunta()";
        // log::info($inssql."respuesta");

    return DB::select($inssql);
    }
     public function TablaGeo(){
           $inssql = "Select * from fnc_ubicacion_geo()";
        // log::info($inssql."respuesta");

    return DB::select($inssql);
    }

    public function TablaIntentos($cedula){
           $inssql = "Select * from fnc_intentos('$cedula')";
        // log::info($inssql."respuesta");

    return DB::select($inssql);
    }

    public function TablaSumatoria($cedula){

           $inssql = "Select * from intentos where cedula ='$cedula';";

    return DB::select($inssql);
    }

    public function RegistroPresentacion($input){
            $inssql = "Select * from fnc_registro_presentacion(array['".$input['cedula']."','".$input['correo']."','".$input['telefono']."','".$input['telefonoha']."','".$input['telefonotrab']."','".$input['direccion']."','".$input['region']."','".$input['estado']."','".$input['municipio']."','".$input['parroquia']."','".$input['ciudad']."','".$input['pntoref']."','true','".$input['usuario']."']);";
        // log::info($input['usuario']);

    return DB::select($inssql);


    }

}