<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        //  create /storage/app/public/images
        'images' => [
            'driver' => 'local',
            'root' => public_path('images'),
            'url' => env('APP_URL') . '/images',
            'visibility' => 'public',
        ],

        'pages' => [
            'driver' => 'local',
            'root' => public_path('pages'),
            'url' => env('APP_URL') . '/pages',
            'visibility' => 'public',
        ],

        'fonts' => [
            'driver' => 'local',
            'root' => public_path('fonts'),
            'url' => env('APP_URL') . '/fonts',
            'visibility' => 'public',
        ],

        'posts' => [
            'driver' => 'local',
            'root' => public_path('posts'),
            'url' => env('APP_URL') . '/posts',
            'visibility' => 'public',
        ],

        'videos' => [
            'driver' => 'local',
            'root' => public_path('videos'),
            'url' => env('APP_URL') . '/videos',
            'visibility' => 'public',
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

    'links' => [
        public_path('images') => storage_path('app/public/images'),
        public_path('pages') => storage_path('app/public/pages'),
        public_path('posts') => storage_path('app/public/posts'),
        public_path('fonts') => storage_path('app/public/fonts'),
        public_path('videos') => storage_path('app/public/videos'),
    ],

];
