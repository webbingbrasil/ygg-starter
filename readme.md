# Getting started

## Requirements

- PHP >= 7.1.3
- Laravel = 5.8
- Ygg CMF = 1.0
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

    git clone git@github.com:webbingbrasil/ygg-starter.git

Switch to the repo folder

    cd ygg-starter

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Generate a new JWT authentication secret key

    php artisan jwt:secret

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

**TL;DR command list**

    git clone git@github.com:webbingbrasil/ygg-starter.git
    cd ygg-starter
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan jwt:secret
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate

## Database seeding

**Populate the database with seed data. This can help you to quickly start testing the project with ready content.**

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh

----------

## Admin Login

To access admin cms go to ``http://ygg-starter.localhost/admin`` and access using one of users in seeded in database.

***Note*** : All users seeded password is ``password``

----------

# Code overview

## Dependencies

- [ygg-cmf](https://github.com/webbingbrasil/ygg-cmf) - For CMS
- [jwt-auth](https://github.com/tymondesigns/jwt-auth) - For authentication using JSON Web Tokens
- [laravel-cors](https://github.com/barryvdh/laravel-cors) - For handling Cross-Origin Resource Sharing (CORS)

## Folders

- `app/Data/Entities` - Contains all the Eloquent models
- `app/Data/Transformer` - Contains all the data transformers
- `app/Data/VO` - Contains all the value objects
- `app/Exceptions` - Contains all the exceptions handles
- `app/Http/Controllers` - Contains application controllers for frontend or api
- `app/Http/Middleware` - Contains the JWT auth middleware
- `app/Ygg` - Contains all cms structure required for Ygg
- `app/Utils` - Contains all application util and helper classes
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the application routes
- `tests` - Contains all the application tests

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------
 
# Authentication
 
This applications uses JSON Web Token (JWT) to handle authentication. The token is passed with each request using the `Authorization` header with `Token` scheme. The JWT authentication middleware handles the validation and authentication of the token. Please check the following sources to learn more about JWT.
 
- https://jwt.io/introduction/
- https://self-issued.info/docs/draft-ietf-oauth-json-web-token.html

----------

# Cross-Origin Resource Sharing (CORS)
 
This applications has CORS enabled by default on all API endpoints. The default configuration allows requests from `http://localhost:3000` and `http://localhost:4200` to help speed up your frontend testing. The CORS allowed origins can be changed by setting them in the config file. Please check the following sources to learn more about CORS.
 
- https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
- https://en.wikipedia.org/wiki/Cross-origin_resource_sharing
- https://www.w3.org/TR/cors

