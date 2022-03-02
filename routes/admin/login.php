<?php
use \App\Http\Response;
use \App\Controller\Admin;

//ADMIN LOGIN ROUTE
$obRouter->get("/admin/login", [
    "middlewares" => [
        "required-admin-logout"
    ],
    function($request) {
        return new Response(200, Admin\Login::getLogin($request));
    }
]);

//ADMIN LOGIN ROUTE (POST)
$obRouter->post("/admin/login", [
    "middlewares" => [
        "required-admin-logout"
    ],
    function($request) {
        return new Response(200, Admin\Login::setLogin($request));
    }
]);

//ADMIN LOGOUT ROUTE
$obRouter->get("/admin/logout", [
    "middlewares" => [
        "required-admin-login"
    ],
    function($request) {
        return new Response(200, Admin\Login::setLogout($request));
    }
]);