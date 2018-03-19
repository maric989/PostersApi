Setting up project instruction:

-Pull App From Git:
https://github.com/maric989/PostersApi.git 

-Rename .env.example to .env

-In project folder run:
    
    composer install
    
-Install swagger

    php composer require "darkaonline/l5-swagger:5.5.*"
    
    php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
    
Open your AppServiceProvider (located in app/Providers) and add this line in register function
    
    $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);

or open your config/app.php and add this line in providers section

    L5Swagger\L5SwaggerServiceProvider::class,

After swagger install do the next:

    php artisan key:genereate

    composer update

After initial setup create database,set it in .env file and run:
    
    php artisan migrate
    
    php artisan db:seed
    
    php artisan l5-swagger:generate

Run in command line

    php artisan serve
    
In browser u can go on
    
    http://localhost:8000/api/documentation

and u will have documentacion for api routes
