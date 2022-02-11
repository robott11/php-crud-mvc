<?php
require __DIR__."/../vendor/autoload.php";

use \App\Utils\View;
use \WilliamCosta\DotEnv\Environment;
use \WilliamCosta\DatabaseManager\Database;
use \App\Http\Middleware\Queue as MiddlewareQueue;

//LOAD ENVIRONMENT VARIABLES
Environment::load(__DIR__."/../");

//DATABASE CONFIG
Database::config(
    getenv("DB_HOST"),
    getenv("DB_NAME"),
    getenv("DB_USER"),
    getenv("DB_PASS"),
    getenv("DB_PORT")
);

//DEFINES THE URL CONSTANT
define("URL", getenv("URL"));

//DEFINES THE DEFAULT VALUE OF THE VARS
View::init([
    "URL" => URL
]);

//DEFINES THE MIDDLEWARE MAPPING
MiddlewareQueue::setMap([
    "maintenance" => \App\Http\Middleware\Maintenance::class
]);

//DEFINES DEFAULT MIDDLEWARES
MiddlewareQueue::setDefault([
    "maintenance"
]);