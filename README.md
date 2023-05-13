
# Laravel 10 - Laravel Telescope

This package for laravel 10, is a package for debugging and monitoring your application. Telescope provides insight into the requests coming into your application, exceptions, log entries, database queries, queued jobs, mail, notifications, cache operations, scheduled tasks, variable dumps and more. Telescope makes a wonderful companion to your local Laravel development environment.





[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)


## Installation

How to setup laravel 10 - laravel telescope

```bash
  composer require laravel/telescope
  php artisan telescope:install
  php artisan migrate

```
## Configuration

To run this package, you will need to add the following environment variables to your .env file

`TELESCOPE_PATH` //set the path to telescope example: telescope

otherwise you can use the default path. For details, you can read the documentation at [Laravel Telescope](https://laravel.com/docs/8.x/telescope)

## Running Tests

To run tests, run the following command

```bash
  php artisan serve
```
and then open your browser and type the url

```bash
  http://localhost:8000/telescope
```

## Screenshots

![App Screenshot](https://i.ibb.co/vVm9RjS/image.png)

## License

[MIT](https://choosealicense.com/licenses/mit/)

