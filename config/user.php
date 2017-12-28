<?php

return [

    'cedula_min_length'                                             => 4,
    'cedula_max_length'                                             => 10,
    'cedula_regex'                                                  => '/^[0-9]+$/',

    'emailalternativo_max_length'                                  => 75,
    'password_max_length'                                          => 20,

    'nombre_min_length'                                            => 8,
    'nombre_max_length'                                            => 50,

    // 'username_min_length'			                            => 3,
    // 'username_max_length'			                            => 15,
    // 'username_regex'				                                => '/^[0-9a-z_]+$/',

    'email_max_length'  				                            => 50,

    'telefono_min_length'                                           => 10,
    'telefono_max_length'			                                => 12,
    'telefono_regex'				                                => '/^[0-9]+$/',

    'preguntasecreta_min_length'                                    => 8,
    'preguntasecreta_max_length'                                    => 50,

    'respuestasecreta_min_length'                                    => 8,
    'respuestasecreta_max_length'                                    => 50,

    'respuestasecreta_confirmation_min_length'                       => 8,
    'respuestasecreta_confirmation_max_length'                       => 50,

    //'password_nuevo_max_length'                                   => 50,

    'password_anterior_min_length'                                  => 6,
    'password_anterior_max_length'                                  => 20,

    'password_min_length'   			                            => 6,
    'password_max_length'       		                            => 20,

    'direccion_min_length'                                          => 10,
    'direccion_max_length'                                          => 200,

    'telefonoresidencial_min_length'                                => 6,
    'telefonoresidencial_max_length'                                => 20,

    'name_min_length'                                               => 10,
    'name_max_length'                                               => 50,
];