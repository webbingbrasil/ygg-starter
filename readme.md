# Getting started

## Requirements

- PHP >= 7.2
- Laravel = 7.0
- Ygg CMF = 2.0
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Installation

Clone the repository

```bash
$ git clone git@github.com:webbingbrasil/ygg-starter.git
```

Switch to the repo folder

```bash
$ cd ygg-starter
```

Install all the dependencies using composer

```bash
$ composer install
```

Copy the example env file and make the required configuration changes in the .env file

```bash
$ cp .env.example .env
```

Generate a new application key

```php
$ php artisan key:generate
```

Run the installation process by running the command:

> ** Note. ** You also need to create a new database and update the `.env` file with credentials and add the URL of your application to the variable `APP_URL`.

```php
$ php artisan ygg:install
```

Create a admin user

```php
php artisan ygg:admin admin admin@admin.com password
```    


**TL;DR command list**

    git clone git@github.com:webbingbrasil/ygg-starter.git
    cd ygg-starter
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan ygg:install
    php artisan ygg:admin admin admin@admin.com password
    

## Admin Login

To access admin cms go to ``http://ygg-starter.localhost/dashboard`` and access using admin user created in installation.

# Code overview

## Dependencies

- [ygg-cmf](https://github.com/webbingbrasil/ygg-cmf) - For CMS development
- [laravel-enum](https://github.com/BenSampo/laravel-enum) - For handling enum
- [laravel-cors](https://github.com/fruitcake/laravel-cors) - For handling Cross-Origin Resource Sharing (CORS)
- [TrustedProxy](https://github.com/fideloper/TrustedProxy) - For handling trusted proxies

## Folders

- `app/Console` - Contains all the console commands and kernel configuration
- `app/Exceptions` - Contains all the exceptions handles
- `app/Http/Controllers` - Contains application controllers for frontend or api
- `app/Http/Middleware` - Contains the JWT auth middleware
- `app/Ygg` - Contains all cms structure required for Ygg
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the application routes
- `tests` - Contains all the application tests


# Cross-Origin Resource Sharing (CORS)
 
This applications has CORS enabled by default on all API endpoints. The default configuration allows requests from `http://localhost:3000` and `http://localhost:4200` to help speed up your frontend testing. The CORS allowed origins can be changed by setting them in the config file. Please check the following sources to learn more about CORS.
 
- https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
- https://en.wikipedia.org/wiki/Cross-origin_resource_sharing
- https://www.w3.org/TR/cors

