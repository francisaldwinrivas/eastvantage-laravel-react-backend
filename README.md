## How to install
1. Clone
2. run `composer install` 
3. run `cp .env.example .env` and replace the database connection values like database name, ..etc
4. run `php artisan migrate --seed`
5. run `php artisan passport:install`
6. run `php artisan migrate`
7. run `php artisan serve`
8. Copy the development url and use it on the frontend
