Setting up project instruction:

-Pull App From Git:
https://github.com/maric989/PostersApi.git 

-Rename .env.example to .env

-In project folder run:
    
    composer install

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
