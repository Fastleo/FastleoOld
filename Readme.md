**Install Fastleo**

    composer require camanru/fastleo

****Add middleware****

    protected $middleware = [
        ...
        \Camanru\Fastleo\ModelsList::class,
        ...
    ]

****Publish the package’s****

    php artisan vendor:publish --tag=fastleo --force

****Create admin****

    php artisan fastleo:user

****Clear cache****

    php artisan route:clear

    php artisan config:clear

    php artisan cache:clear

    composer dump-autoload

****Fastleo columns****

    public $fastleo_columns = [
        'column' => [
            'name' => 'Column Name',
            'type' => 'string', // [string|text|integer|checkbox|datetime|array|multiarray|select|multiselect]
            'media' => false, // default false
            'tinymce' => false, // default false
            'visible' => true, // default true
            'editing' => true, // default true
            'data' => [], // if type array or select [array|model_name]
        ],
    ];
    
