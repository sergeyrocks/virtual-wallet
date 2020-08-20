# Virtual wallet app

`.env` file was left on purpose.

Run `composer install`

Run `php artisan migrate` after setting up your database credentials in `.env' file

Run `php artisan serve` to make the app accessible by http://localhost:8000

If you don't have an development environment for Laravel already, consider using the [Bitnami Laravel Development Container](https://hub.docker.com/r/bitnami/laravel/).

App requires `php 7.4` and `bcmath` extension for calculations precision, make sure you have it installed.

For quickstart you can run `php artisan db:seed` to add user with wallet and 15 transactions. Users' password is set to `1`
