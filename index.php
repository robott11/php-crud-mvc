<?php
require __DIR__."/vendor/autoload.php";

use \App\Http\Router;
use \App\Utils\View;

define("URL", "http://localhost");

//DEFINES THE DEFAULT VALUE OF THE VARS
View::init([
    "URL" => URL
]);

//INITIATES THE ROUTER
$obRouter = new Router(URL);

//INCLUDE THE PAGES ROUTES
include __DIR__."/routes/pages.php";

//PRINT THE ROUTER RESPONSE
$obRouter->run()
         ->sendResponse();
