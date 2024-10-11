<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
     */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

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

    'cloud'   => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
     */

    'disks'   => [

        'local'          => [
            'driver' => 'local',
            'root'   => storage_path('app'),
        ],

        'public'         => [
            'driver'     => 'local',
            'root'       => storage_path('app/public'),
            'url'        => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3'             => [
            'driver'     => 's3',
            'key'        => env('AWS_ACCESS_KEY_ID'),
            'secret'     => env('AWS_SECRET_ACCESS_KEY'),
            'region'     => env('AWS_DEFAULT_REGION'),
            'bucket'     => env('AWS_BUCKET'),
            'url'        => env('AWS_URL'),
            'endpoint'   => env('AWS_ENDPOINT'),
            'visibility' => 'public',
        ],

        'path_public'      => [
            'driver'     => 'local',
            //            'root' => storage_path('app/public'),
            'root'       => public_path(''),
            // 'url'        => public_path(),
            'url'        => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],

        'filtrados'      => [
            'driver'     => 'local',
            //            'root' => storage_path('app/public'),
            'root'       => public_path("/files/filtrados"),
            'url'        => public_path("/files/filtrados"),
            // 'url'        => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'db_backup'      => [
            // 'driver'     => 'local',
            'driver'     => 's3',
            //            'root' => storage_path('app/public'),
            'root'       => public_path("/files/db_backup"),
            'url'        => public_path("/files/db_backup"),
            // 'url'        => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        /**
         * Serfin
         */

        'excel'          => [
            'driver'     => 'local',
            //            'root' => storage_path('app/public'),
            'root'       => public_path("/files/cobranza" . date('y/m/d/')),
            'url'        => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'cobranza_doble' => [
            'driver'     => 'local',
            //            'root' => storage_path('app/public'),
            'root'       => public_path("/files/cobranza_doble"),
            'url'        => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'public_cobra'   => [
            'driver'     => 'local',
            //            'root' => storage_path('app/public'),
            'root'       => public_path(''),
            'url'        => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        /**
         * Buzon SFTP serfin
         */
        'sftp'           => [
            'driver'      => 'sftp',
            'host'        => '170.169.130.85',
            'username'    => 'se20273',
            'port'        => 22,
            'password'    => '',
            'privateKey'  => public_path() . '/files/keys/beneficios_rsa',
            'permissions' => [
                'file' => [
                    'public'  => 0775,
                    'private' => 0775,
                    // 'private' => 0600,
                ],
                'dir'  => [
                    'public'  => 0775,
                    // 'private' => 0700,
                    'private' => 0775,
                ],
            ],
        ],


        /*Conexion serfin prueba*/
        'sftp_'          => [
            'driver'      => 'ftp',
            'host'        => 'optucorp.com',
            'username'    => 'cobranza@optucorp.com',
            'password'    => 'Opt.cobranza20',
            'permissions' => [
                'file' => [
                    'public'  => 0775,
                    'private' => 0600,
                ],
                'dir'  => [
                    'public'  => 0775,
                    'private' => 0700,
                ],
            ],
        ],

        /*Conexion a sistema de cobranza optucorp*/
        'cobranzadev'    => [
            'driver'      => 'ftp',
            'host'        => 'optucorp.com',
            'username'    => 'cobranzadev@optucorp.com',
            'password'    => 'Opt.cobranza2020',
            'permissions' => [
                'file' => [
                    'public'  => 0775,
                    'private' => 0600,
                ],
                'dir'  => [
                    'public'  => 0775,
                    'private' => 0700,
                ],
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
     */

    'links'   => [
        public_path('storage') => storage_path('app/public'),
    ],

];
