# Virtual wallet app

`.env` file is left on purpose for quick access to pre-made configuration.

Run `docker-compose up -d` to install and start docker containers

Run `docker-compose exec php composer install -d /app`

Run `docker-compose exec php php /app/artisan migrate`

App is accessed at `localhost:8000`

For quickstart you can run `docker-compose exec php php /app/artisan db:seed` to add user with wallet and 15 transactions.

Login details:
e-mail: `user@example.org`,
password: `1`
