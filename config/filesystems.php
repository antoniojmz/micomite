<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. A "local" driver, as well as a variety of cloud
    | based drivers are available for your choosing. Just store away!
    |
    | Supported: "local", "ftp", "s3", "rackspace"
    |
    */

    'default' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 's3',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */
 
    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'reglamentos' => [
                'driver' => 'local',
                'root'   => storage_path('../public/reglamentos'),
        ],

        'fotos-perfil' => [
                'driver' => 'local',
                'root'   => storage_path('../public/fotos-perfil'),
        ],

        'fotos-condominios' => [
                'driver' => 'local',
                'root'   => storage_path('../public/fotos-condominios'),
        ],

        'fotos-instalaciones' => [
                'driver' => 'local',
                'root'   => storage_path('../public/fotos-instalaciones'),
        ],
        'fotos-seguridad' => [
                'driver' => 'local',
                'root'   => storage_path('../public/fotos-seguridad'),
        ],
        'fotos-proveedores' => [
                'driver' => 'local',
                'root'   => storage_path('../public/fotos-proveedores'),
        ],
        'fotos-publicidad' => [
                'driver' => 'local',
                'root'   => storage_path('../public/fotos-publicidad'),
        ],
        'fotos-pagos' => [
                'driver' => 'local',
                'root'   => storage_path('../public/fotos-pagos'),
        ],
        'fotos-gastos' => [
            'driver' => 'local',
            'root'   => storage_path('../public/fotos-gastos'),
        ],
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => 'your-key',
            'secret' => 'your-secret',
            'region' => 'your-region',
            'bucket' => 'your-bucket',
        ],

        // 'report_fuente' = > [
        //     'driver' => 'local',
        //     'root' => storage_path('app/public/reporte/fuente'),
        // ],

        // 'outReport' = > [
        //     'driver' => 'local',
        //     'root' => storage_path('app/public/reporte/out'),
        // ],
    ],
];
