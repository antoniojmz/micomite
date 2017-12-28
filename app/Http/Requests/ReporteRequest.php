<?php
namespace App\Http\Requests;
use App\Http\Requests\Request;

// Facades
use Route;
use Config;
use Lang;
use Auth;
use Validator;
use Carbon\Carbon;

class ReporteRequest extends Request {
    public function __construct() {
        $this->validator = app('validator');
        $this->validatefechadesdemayor($this->validator);
    }

    public function authorize(){ return true; }


    public function validatefechadesdemayor($validator) {
        $validator->extend('valfechadesde', function($attribute, $value, $parameters, $validator) {
        // dd($validator);
            if (strlen($validator->getData()['fecha_desde']) > 0 && strlen($validator->getData()['fecha_hasta']) > 0){
                $arr = explode('/', $validator->getData()['fecha_desde']);
                $fd = Carbon::create($arr[1], $arr[0], 01, 0);
                $arr = explode('/', $validator->getData()['fecha_hasta']);
                $fh = Carbon::create($arr[1], $arr[0], 01, 0);
                if ($fd > $fh){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        });
    }

    public function rules() {
        // $currentRoute = Route::currentRouteName();
        $id_reporte = (integer) $this->request->all()['id_reporte'];
        // dd($id_reporte);

        switch ($id_reporte) {
            case 2:
                    $rules = [
                        'fecha_desde'         => 'required',
                        'fecha_hasta'         => 'required',
                        'txtfecha_desde' => 'required|valfechadesde',

                    ];
                    break;
            default:
                $rules = [];

        }
        return $rules;
    }

    public function attributes() {
        return [

        ];
    }

    public function messages() {
        return [
            'valfechadesde'     =>      ' Verifique; la fecha desde debe ser menor o igual a la fecha hasta'
        ];
    }
}