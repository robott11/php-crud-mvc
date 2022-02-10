<?php
require __DIR__."/../vendor/autoload.php";

use \App\Utils\View;
use \WilliamCosta\DotEnv\Environment;
use \WilliamCosta\DatabaseManager\Database;

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