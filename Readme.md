**Install Fastleo**

`composer require camanru/fastleo`

Create admin

`php artisan fastleo:user`

If use filemanager

Publish the package’s 

`php artisan vendor:publish --tag=lfm_config`

`php artisan vendor:publish --tag=lfm_public`

Clear cache

`php artisan route:clear`

`php artisan config:clear`

`php artisan cache:clear`

`composer dump-autoload`