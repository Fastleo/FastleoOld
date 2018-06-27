**Install Fastleo**

    composer require camanru/fastleo

****Add middleware****

    protected $middleware = [
        ...
        \Camanru\Fastleo\ModelsList::class,
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
    
    public $fastleo_model = [
        'menu' => true,
        'name' => 'ModelName',
        'title' => 'Model Title',
    ];

    public $fastleo_columns = [
        'column_name' => [
            'title' => 'Column Name',
            'type' => 'string', // [string|text|integer|checkbox|select]
            'media' => false, // if string type, default false
            'tinymce' => false, // if text type, default false
            'visible' => true, // default true
            'editing' => true, // default true
            'description' => '', // default ''
            'multiple' => false, // if select type, default false
            'data' => [], // array, example [10,20,30]
            'data' => '', // example 'App\User:id:email:admin:1'
                          // 'Model:column_key:column_value'
                          // 'Model:column_key:column_value:where:value'
                          // 'Model::column_value:where:value'
        ],
    ];
    
