<?php

namespace App\Controller\Admin;

use \App\Utils\View;

class Home extends Page
{
    /**
     * Method responsible for returning the content(view) of the admin home page
     *
     * @param Request $request
     * @return string
     */
    public static function getHome(object $request): string
    {
        //HOME CONTENT
        $content = View::render("admin/modules/home/index", []);

        //RETURN THE PAGE
        return parent::getPanel("Admin - Home", $content, "home");
    }
}
