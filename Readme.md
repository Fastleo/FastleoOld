**Install Fastleo**

`composer require camanru/fastleo`

Create admin

`php artisan fastleo:user`

Publish the package’s 

`php artisan vendor:publish --tag=fastleo --force`

Clear cache

`php artisan route:clear`

`php artisan config:clear`

`php artisan cache:clear`

`composer dump-autoload`