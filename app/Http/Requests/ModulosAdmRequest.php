<?php
namespace App\Http\Requests;
use App\Http\Requests\Request;

// Facades
use Route;
use Config;
use Lang;
use Auth;

class ModulosAdmRequest extends Request {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $currentRoute = Route::currentRouteName();
        // return ($currentRoute);
        switch ($currentRoute) {
            case "modulospoderes":
                    $rules = [
                        'id_modulo' => [
                            'required',
                        ],
                        'id_poder' => [
                            'required',
                        ],
                    ];
                    break;
            case "addmodulospoderes":
                    $rules = [
                        'id_modulo' => [
                            'required',
                        ],
                        'id_poder[]' => [
                            'required',
                        ],
                    ];
                    break;
        }
        return $rules;
    }

    /**
     * Set nice attributes names
     *
     * @return array
    */
    public function attributes() {
        return [
            'id_modulo'                                     => 'módulos',
            'id_poder'                                      => 'poder',
        ];
    }

    /**
     * Set custom messages
     *
     * @return array
    */
    public function messages() {
        return [

        ];
    }
}