<?php
namespace App\Controller\Pages;

use \App\Utils\View;

class Page
{
    /**
     * renders the page header
     * @return string
     */
    private static function getHeader(): string
    {
        return View::render("pages/header");
    }

    /**
     * renders the page footer
     * @return string
     */
    private static function getFooter(): string
    {
        return View::render("pages/footer");
    }

    /**
     * Method responsible for returning the content(view) of the generic page
     * @return string
     */
    public static function getPage(string $title, string $content): string
    {
        return View::render("pages/page", [
            "title"   => $title,
            "header"  => self::getHeader(),
            "content" => $content,
            "footer"  => self::getFooter()
        ]);
    }
}
