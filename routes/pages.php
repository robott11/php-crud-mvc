<?php
use \App\Http\Response;
use \App\Controller\Pages;

//HOME ROUTE
$obRouter->get("/", [
    function() {
        return new Response(200, pages\Home::getHome());
    }
]);

$obRouter->get("/sobre", [
    function() {
        return new Response(200, pages\Home::getHome());
    }
]);
