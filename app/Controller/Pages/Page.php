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
     * renders the paginatin layout
     *
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    public static function getPagination($request, $obPagination): string
    {
        //PAGES
        $pages = $obPagination->getPages();
        
        //VERIFY THE AMOUNT OF PAGES
        if (count($pages) <= 1) return "";

        //LINKS
        $links = "";
        
        //CURRENT URL (without gets)
        $url = $request->getRouter()->getCurrentUrl();

        //GETS
        $queryParams = $request->getQueryParams();

        //RENDER THE LINKS
        foreach ($pages as $page) {
            //ALTERS THE PAGE
            $queryParams["page"] = $page["page"];

            //LINK
            $link = $url."?".http_build_query($queryParams);

            //VIEW
            $links .= View::render("pages/pagination/link", [
                "page"   => $page["page"],
                "link"   => $link,
                "active" => $page["current"] ? "active" : ""
            ]);
        }

        return View::render("pages/pagination/box", [
            "link" => $links
        ]);
        
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
