<?php
namespace App\Http\Requests;
use App\Http\Requests\Request;

// Facades
use Route;
use Config;
use Lang;
use Auth;

class UserRequest extends Request {
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
        // dd($currentRoute);
        switch ($currentRoute) {
            case "login":
                    $rules = [
                        'username' => [
                            'required',
                            // 'exists:usuarios',
                        ],
                        'password' => [
                            'required',
                        ],
                         'remember_me' => [
                            'in:true',
                        ],
                    ];
                    break;
            case "cambio_clave":
                    $rules = [
                        'password_anterior' => [
                            'required',
                            'min:' . Config::get('user.password_anterior_min_length'),
                            'max:' . Config::get('user.password_anterior_max_length'),
                        ],
                        'password' => [
                            'required',
                            'confirmed',
                            'min:' . Config::get('user.password_min_length'),
                            'max:' . Config::get('user.password_max_length'),
                        ],
                    ];
                    break;
            case "buscar":
                    $rules = [
                        'cedula' => [
                            'required',
                            'min:' . Config::get('user.cedula_min_length'),
                            'max:' . Config::get('user.cedula_max_length'),
                            'regex:' . Config::get('user.cedula_regex'),
                        ],
                        'nacionalidad' => [
                            'required',
                            'min:' . Config::get('user.nacionalidad_min_length'),
                            'max:' . Config::get('user.nacionalidad_max_length'),
                            'regex:' . Config::get('user.nacionalidad_regex'),
                        ],
                    ];
                    break;
            case "nueva_clave":
                $rules = [
                    'password' => [
                        'required',
                        'confirmed',
                        'min:' . Config::get('user.password_min_length'),
                        'max:' . Config::get('user.password_max_length'),
                    ],
                ];
                break;
            case "recordar_clave":
                $rules = [
                    'txtPreguntaSecreta' => [
                        'required',
                    ],
                    'respuestasecreta' => [
                        'required',
                        'min:' . Config::get('user.respuestasecreta_min_length'),
                        'max:' . Config::get('user.respuestasecreta_max_length'),
                    ],
                ];
                break;
            case "actualizarps":
                $rules = [
                    'cedula' => [
                        'required',
                        'min:' . Config::get('user.cedula_min_length'),
                        'max:' . Config::get('user.cedula_max_length'),
                        'regex:' . Config::get('user.cedula_regex'),
                    ],
                    'naci' => [
                        'unique:usuarios,cedula,'.Auth::user()->user_id.',user_id',
                    ],
                    'emailalternativo' => [
                        'required',
                        'email',
                        'max:' . Config::get('user.emailalternativo_max_length'),
                        'unique:usuarios,emailalternativo,'.Auth::user()->user_id.',user_id',
                    ],
                    'preguntasecreta' => [
                        'required',
                    ],
                    'respuestasecreta' => [
                        'required',
                        'confirmed',
                        'min:' . Config::get('user.respuestasecreta_min_length'),
                        'max:' . Config::get('user.respuestasecreta_max_length'),
                    ],
                ];
                break;
            case "actdatos":
                $rules = [
                    'password' => [
                        'required',
                        'min:' . Config::get('user.password_min_length'),
                        'max:' . Config::get('user.password_max_length'),
                    ],
                ];
                break;
            case "procesaractdatos":
            // dd('validacion userddd');
            $rules = [
                'nombre' => [
                        'required',
                        'min:' . Config::get('user.nombre_min_length'),
                        'max:' . Config::get('user.nombre_max_length'),
                ],
                'telefono' => [
                    'required',
                    'min:' . Config::get('user.telefono_min_length'),
                    'max:' . Config::get('user.telefono_max_length'),
                    'regex:' . Config::get('user.telefono_regex'),
                ],
                'telefonoresidencial' => [
                    'required',
                    'min:' . Config::get('user.telefonoresidencial_min_length'),
                    'max:' . Config::get('user.telefonoresidencial_max_length'),
                ],
                'emailalternativo' => [
                    'required',
                    'email',
                    'max:' . Config::get('user.emailalternativo_max_length'),
                    'unique:usuarios,emailalternativo,'.Auth::user()->user_id.',user_id',
                ],
            ];
                break;
            case "solicitudcuenta":
            $rules = [
                'nombre' => [
                    'required',
                ],
                'telefono' => [
                    'required',
                    'min:' . Config::get('user.telefono_min_length'),
                    'max:' . Config::get('user.telefono_max_length'),
                    'regex:' . Config::get('user.telefono_regex'),
                ],
                'emailalternativo' => [
                    'required',
                    'email',
                    'unique:usuarios',
                    'max:' . Config::get('user.emailalternativo_max_length'),
                ],
                'preguntasecreta' => [
                    'required',
                    'min:' . Config::get('user.preguntasecreta_min_length'),
                    'max:' . Config::get('user.preguntasecreta_max_length'),
                ],
                'respuestasecreta' => [
                    'required',
                    'confirmed',
                    'min:' . Config::get('user.respuestasecreta_min_length'),
                    'max:' . Config::get('user.respuestasecreta_max_length'),
                ],
            ];
                break;
            case "actcuenta":
            $rules = [
                'cedula' => [
                    'required',
                    'max:' . Config::get('user.cedula_max_length'),
                    'regex:' . Config::get('user.cedula_regex'),
                ],
                'naci' => [
                    'required',
                    'unique:usuarios,cedula',
                ],
                'nombre' => [
                    'required',
                ],
                'telefono' => [
                    'required',
                    'min:' . Config::get('user.telefono_min_length'),
                    'max:' . Config::get('user.telefono_max_length'),
                    'regex:' . Config::get('user.telefono_regex'),
                ],
                'emailalternativo' => [
                    'required',
                    'email',
                    'unique:usuarios',
                    'max:' . Config::get('user.emailalternativo_max_length'),
                ],
                'preguntasecreta' => [
                    'required',
                    'min:' . Config::get('user.preguntasecreta_min_length'),
                    'max:' . Config::get('user.preguntasecreta_max_length'),
                ],
                'respuestasecreta' => [
                    'required',
                    'confirmed',
                    'min:' . Config::get('user.respuestasecreta_min_length'),
                    'max:' . Config::get('user.respuestasecreta_max_length'),
                ],
            ];
                break;
        case "modificarps":
                $rules = [
                    'password' => [
                        'required',
                        'min:' . Config::get('user.password_min_length'),
                        'max:' . Config::get('user.password_max_length'),
                    ],
                ];
                break;
            case "procesarps":
            $rules = [
                'emailalternativo' => [
                    'required',
                    'email',
                    'unique:usuarios',
                    'max:' . Config::get('user.emailalternativo_max_length'),
                ],
                'preguntasecreta' => [
                    'required',
                    'min:' . Config::get('user.preguntasecreta_min_length'),
                    'max:' . Config::get('user.preguntasecreta_max_length'),
                ],
                'respuestasecreta' => [
                    'required',
                    'confirmed',
                    'min:' . Config::get('user.respuestasecreta_min_length'),
                    'max:' . Config::get('user.respuestasecreta_max_length'),
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
            'email'                                     => Lang::get('auth.email_label'),
            // 'name'                                   => Lang::get('auth.name_label'),
            'emailalternativo'                          => Lang::get('auth.emailalternativo_label'),
            'password'                                  => Lang::get('auth.password_label'),
            'username'                                  => Lang::get('auth.username_label'),
            'cedula'                                    => Lang::get('auth.cedula_label'),
            'naci'                                      => Lang::get('auth.cedula_label'),
            'telefono'                                  => Lang::get('auth.telefono_label'),
            'preguntasecreta'                           => Lang::get('auth.preguntasecreta_label'),
            'respuestasecreta'                          => Lang::get('auth.respuestasecreta_label'),
            'respuesta_secreta_confirmation'            => Lang::get('auth.respuesta_secreta_confirmation_label'),
            'password_anterior'                         => Lang::get('auth.password_anterior_label'),
            'telefonoresidencial'                       => Lang::get('auth.telefonoresidencial_label'),
            'txtPreguntaSecreta'                        => 'Pregunta secreta',
        ];
    }

    /**
     * Set custom messages
     *
     * @return array
    */
    public function messages() {
        return [
            'cedula.regex'                         => Lang::get('auth.cedula_error_regex'),
            'accept_disclaimer.required'           => Lang::get('auth.accept_disclaimer_error'),
            'accept_disclaimer.in'                 => Lang::get('auth.accept_disclaimer_error'),
            'email_alternativo.unique'             => Lang::get('auth.email_alternativo_error_unique'),
            'telefono.regex'                       => Lang::get('auth.telefono_error_regex'),
            'txtPreguntaSecreta.required'          => ' Debe seleccionar un elemento',
        ];
    }
}