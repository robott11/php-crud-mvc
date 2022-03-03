<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class About extends Page
{
    /**
     * Method responsible for returning the content(view) of the about page
     * 
     * @return string
     */
    public static function getAbout(): string
    {
        //ORGANIZATION MODEL
        $obOrganization = new Organization();

        //ABOUT VIEW
        $content = View::render("pages/about", [
            "name"        => $obOrganization->name,
            "description" => $obOrganization->description,
            "site"        => $obOrganization->site
        ]);

        //PAGE VIEW
        return parent::getPage("Sobre", $content);
    }
}
