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

****Fastleo setting model****

    public $fastleo = true;
    
    public $fastleo_model = [
        'menu' => true,
        'name' => 'ModelName',
        'title' => 'Model Title',
    ];

    public $fastleo_columns = [
        'column_name' => [
            'title' => 'Column Name',
            'type' => 'string', // [string|text|integer|checkbox|datetime|array|multiarray|select|multiselect]
            'media' => false, // default false
            'tinymce' => false, // default false
            'visible' => true, // default true
            'editing' => true, // default true
            'description' => 'string', // default false
            'data' => [], // [array|ModelName], example 'Article:column_key:column_value', example [10,20,30]
        ],
    ];
    
