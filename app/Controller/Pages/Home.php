<?php
namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Home extends Page
{
    /**
     * Method responsible for returning the content(view) of the home page
     * @return string
     */
    public static function getHome(): string
    {
        //ORGANIZATION MODEL
        $obOrganization = new Organization();

        //HOME VIEW
        $content = View::render("pages/home", [
            "name"        => $obOrganization->name,
            "description" => $obOrganization->description,
            "site"        => $obOrganization->site
        ]);

        //PAGE VIEW
        return parent::getPage("Home", $content);
    }
}
