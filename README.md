# Web Challenge PHP - Laravel Backend

Laravel Specificiations:
- Laravel 5.6
- Laravel Spark 6.0
- Packages:l5-swagger

## Requirements:
```
1- composer to install vendors
2- php 7.2
3- MySql
```

## Installation:
```
Before installing consider to have running-> mysql
0- Set permission RW to storage folder -> subfoldres.
1- Open terminal inside solution
2- Install vendor running > composer install
3- Create .env file from .env.dev and config database credentials.
4- Create tables running > php artisan migrate
5- Run server > php artisan serve ( defualt port: 8000)
6- Run php artisan l5-swagger:generate (Documention)
```

## Testing:
```
1- Run vendor/bin/phpunit
```