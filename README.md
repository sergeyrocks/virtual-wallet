# Virtual wallet app

### Local setup
You will need docker installed and launched, guide can be found on [docker home page](https://www.docker.com)

Copy `.env.testing` to `.env`

Run `composer install`

Run `./vendor/bin/sail up -d`

Run `./vendor/bin/sail php artisan migrate`

App can be accessed at [http://localhost:8000](http://localhost:8000)

For quickstart you can run `./vendor/bin/sail php artisan db:seed` to add user with wallet and 15 transactions.

Login details:
e-mail: `user@example.org`,
password: `password`
