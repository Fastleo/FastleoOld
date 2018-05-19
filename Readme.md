**Install Fastleo**

`composer require camanru/fastleo`

Add middleware

`protected $middleware = [`

`\Camanru\Fastleo\ModelsList::class,`

`]`

Publish the package’s 

`php artisan vendor:publish --tag=fastleo --force`

Create admin

`php artisan fastleo:user`

Clear cache

`php artisan route:clear`

`php artisan config:clear`

`php artisan cache:clear`

`composer dump-autoload`