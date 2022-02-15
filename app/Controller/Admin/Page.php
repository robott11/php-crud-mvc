<?php
namespace App\Controller\Admin;

use App\Utils\View;

class Page
{
    /**
     * Method responsible for returning the content(view) of the generic
     * admin page
     * 
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getPage(string $title, string $content): string
    {
        return View::render("admin/page", [
            "title"   => $title,
            "content" => $content
        ]);
    }
}
