<?php
use \App\Http\Response;
use \App\Controller\Admin;

//ADMIN TESTIMONIES ROUTE
$obRouter->get("/admin/testimonies", [
    "middlewares" => [
        "required-admin-login"
    ],
    function($request) {
        return new Response(200, Admin\Testimony::getTestimonies($request));
    }
]);

//ADMIN TESTIMONY REGISTER ROUTE
$obRouter->get("/admin/testimonies/new", [
    "middlewares" => [
        "required-admin-login"
    ],
    function($request) {
        return new Response(200, Admin\Testimony::getNewTestimony($request));
    }
]);

//ADMIN TESTIMONY REGISTER ROUTE (POST)
$obRouter->post("/admin/testimonies/new", [
    "middlewares" => [
        "required-admin-login"
    ],
    function($request) {
        return new Response(200, Admin\Testimony::setNewTestimony($request));
    }
]);

//ADMIN TESTIMONY EDIT ROUTE
$obRouter->get("/admin/testimonies/{id}/edit", [
    "middlewares" => [
        "required-admin-login"
    ],
    function($request, $id) {
        return new Response(200, Admin\Testimony::getEditTestimony($request, $id));
    }
]);

//ADMIN TESTIMONY EDIT ROUTE (POST)
$obRouter->post("/admin/testimonies/{id}/edit", [
    "middlewares" => [
        "required-admin-login"
    ],
    function($request, $id) {
        return new Response(200, Admin\Testimony::setEditTestimony($request, $id));
    }
]);

//ADMIN TESTIMONY DELETE ROUTE
$obRouter->get("/admin/testimonies/{id}/delete", [
    "middlewares" => [
        "required-admin-login"
    ],
    function($request, $id) {
        return new Response(200, Admin\Testimony::getDeleteTestimony($request, $id));
    }
]);

//ADMIN TESTIMONY DELETE ROUTE (POST)
$obRouter->post("/admin/testimonies/{id}/delete", [
    "middlewares" => [
        "required-admin-login"
    ],
    function($request, $id) {
        return new Response(200, Admin\Testimony::setDeleteTestimony($request, $id));
    }
]);