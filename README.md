## Laravel 8 rest

-   Clone this repo
-   run composer install
-   setup database connection in `.env` file
-   run `php artisan migrate:fresh --seed` to migrate and seed default data
-   run `php artisan serve --port="3000"`

## Routes

# Public route can access without token

-   localhost:3000/api/v1/auth/register
-   localhost:3000/api/v1/auth/login
-   localhost:3000/api/v1/quote

# Private route need bearer_token to access

-   localhost:3000/api/v1/auth/logout
-   localhost:3000/api/v1/transaction

# POSTMAN

`{root_dir}/laravel-rest.postman_collection.json`
Just import to postman

# MISC

-   only accept application/json header.
-   for transaction limit to 2 request per minute.
-   token get from `login` route.
