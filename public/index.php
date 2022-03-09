<?php
require __DIR__."/../includes/app.php";

use \App\Http\Router;

//INITIATES THE ROUTER
$obRouter = new Router(URL);

//INCLUDE THE PAGES ROUTES
include __DIR__."/../routes/pages.php";

//INCLUDE THE ADMIN ROUTES
include __DIR__."/../routes/admin.php";

//PRINT THE ROUTER RESPONSE
$obRouter->run()
         ->sendResponse();
