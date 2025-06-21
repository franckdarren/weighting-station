
## Installation

``

`cp .env.example .env`
make the needed changes regarding name, url, database connection

`mkdir -p bootstrap/cache`

`chmod -R 775 bootstrap/cache`

`mkdir -p storage/framework/{views,sessions,cache}`

`mkdir -p storage/framework/cache/data`

`chmod -R 775 storage`

`composer install`

`npm install`

`php artisan key:generate`
Just if you have not the APP_KEY value in your file .env

`php artisan migrate`

`php artisan excel:sync`

`php artisan db:seed`

`php artisan serve`

`npm run dev`

`php artisan schedule:work`

`php artisan queue:work`

`php artisan make:filament-user`
For create your first access to app