# basic_docker_php_nginx_config

# laravel-recap

# Project Details

## This project is an api that has the ff functionalities
1. Multi guard authentication with laravel sanctum
2. Authenticating each user action based on their roles by using policy
   a. Admin has One Role
   b. A role can be used by many Admin
   c. A role have many permissions

## To set this up, follow steps below
1. Clone the repository
2. cd recap

## After cloning and entering on the project directory, run commands below
1. make build
2. make up

## After building and running the container, enter inside the container
1. make php-root

## inside the container, run commands below
1. composer install
2. php artisan tinker

# Have list of features in mind?
If you want to add features/modules in your application, you can check config/modules.php and add your own modules. Just follow the example on that file

## Finally, run the commands below to have an admin user, a super_admin role and a features/modules that you will be using
Assuming you are still inside the container, just run the following commands
1. use App\Jobs\RunInitialSetup;
2. (new RunInitialSetup('your-email@gmail.com', 'your-password'))->handle();
