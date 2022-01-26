<?php
require __DIR__."/vendor/autoload.php";

use \App\Http\Router;

define("URL", "http://localhost");
$obRouter = new Router(URL);

//INCLUDE THE PAGES ROUTES
include __DIR__."/routes/pages.php";

//PRINT THE ROUTER RESPONSE
$obRouter->run()
         ->sendResponse();
