<?php
use \App\Http\Response;
use \App\Controller\Admin;

//ADMIN USERS ROUTE
$obRouter->get("/admin/users", [
    "middlewares" => [
        "required-admin-login"
    ],
    function($request) {
        return new Response(200, Admin\User::getUsers($request));
    }
]);

//ADMIN USER REGISTER ROUTE
$obRouter->get("/admin/users/new", [
    "middlewares" => [
        "required-admin-login"
    ],
    function($request) {
        return new Response(200, Admin\User::getNewUser($request));
    }
]);

//ADMIN USER REGISTER ROUTE (POST)
$obRouter->post("/admin/users/new", [
    "middlewares" => [
        "required-admin-login"
    ],
    function($request) {
        return new Response(200, Admin\User::setNewUser($request));
    }
]);

//ADMIN USER EDIT ROUTE
$obRouter->get("/admin/users/{id}/edit", [
    "middlewares" => [
        "required-admin-login"
    ],
    function($request, $id) {
        return new Response(200, Admin\User::getEditUser($request, $id));
    }
]);

//ADMIN USER EDIT ROUTE (POST)
$obRouter->post("/admin/users/{id}/edit", [
    "middlewares" => [
        "required-admin-login"
    ],
    function($request, $id) {
        return new Response(200, Admin\User::setEditUser($request, $id));
    }
]);

//ADMIN USER DELETE ROUTE
$obRouter->get("/admin/users/{id}/delete", [
    "middlewares" => [
        "required-admin-login"
    ],
    function($request, $id) {
        return new Response(200, Admin\User::getDeleteUser($request, $id));
    }
]);

//ADMIN USER DELETE ROUTE (POST)
$obRouter->post("/admin/users/{id}/delete", [
    "middlewares" => [
        "required-admin-login"
    ],
    function($request, $id) {
        return new Response(200, Admin\User::setDeleteUser($request, $id));
    }
]);