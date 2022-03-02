<?php
use \App\Http\Response;
use \App\Controller\Admin;

//ADMIN ROUTE
$obRouter->get("/admin", [
    "middlewares" => [
        "required-admin-login"
    ],
    function($request) {
        return new Response(200, Admin\Home::getHome($request));
    }
]);