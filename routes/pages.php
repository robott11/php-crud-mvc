<?php
use \App\Http\Response;
use \App\Controller\Pages;

//HOME ROUTE
$obRouter->get("/", [
    function() {
        return new Response(200, pages\Home::getHome());
    }
]);

//ABOUT ROUTE
$obRouter->get("/sobre", [
    function() {
        return new Response(200, pages\About::getAbout());
    }
]);

//DYNAMIC ROUTE
$obRouter->get("/pagina/{pageId}/{action}", [
    function($pageId, $action) {
        return new Response(200, "Página: ".$pageId."<br>Ação: ".$action);
    }
]);
