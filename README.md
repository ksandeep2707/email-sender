
Run on localhost:

##Mac Os, Ubuntu and windows users continue here:

● Create a database locally named utf8_general_ci
● Download composer https://getcomposer.org/download/
● Pull Laravel/php project from git provider.
● Rename .env.example file to .env inside your project root and fill the database
information. (windows won't let you do it, so you have to open your console cd
your project root directory and run mv .env.example .env )
● Open the console and cd your project root directory
● Run composer install or php composer.phar install
● Run composer update
● Please update the mail credentials in the .env file
● Run php artisan key:generate
● Run php artisan migrate
● Run php artisan serve
