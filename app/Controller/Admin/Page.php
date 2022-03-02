<?php
namespace App\Controller\Admin;

use App\Utils\View;

class Page
{
    /**
     * available panel modules
     *
     * @var array
     */
    private static $modules = [
        "home" => [
            "label" => "Home",
            "link"  => URL."/admin"
        ],
        "testimonies" => [
            "label" => "Depoimentos",
            "link"  => URL."/admin/testimonies"
        ],
        "users" => [
            "label" => "Usuários",
            "link"  => URL."/admin/users"
        ]
    ];

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

    /**
     * render the menu view
     *
     * @param string $currentModule
     * @return string
     */
    private static function getMenu(string $currentModule): string
    {
        //MENU LINKS
        $links = "";

        //ITERATE THE MODULES
        foreach (self::$modules as $hash => $module) {
            $links .= View::render("admin/menu/link", [
                "label"   => $module["label"],
                "link"    => $module["link"],
                "current" => $hash == $currentModule ? "text-danger" : "" 
            ]);
        }

        //RETURN THE MENU VIEW
        return View::render("admin/menu/box", [
            "links" => $links
        ]);
    }

    /**
     * renders admin panel view with dynamic content
     *
     * @param string $title
     * @param string $content
     * @param string $currentModule
     * @return string
     */
    public static function getPanel(string $title, string $content, string $currentModule): string
    {
        //RENDERS THE PANEL VIEW
        $contentPanel = View::render("admin/panel", [
            "menu"    => self::getMenu($currentModule),
            "content" => $content
        ]);

        //RETURNS THE REDERED VIEW
        return self::getPage($title, $contentPanel);
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
            $links .= View::render("admin/modules/pagination/link", [
                "page"   => $page["page"],
                "link"   => $link,
                "active" => $page["current"] ? "active" : ""
            ]);
        }

        return View::render("admin/modules/pagination/box", [
            "link" => $links
        ]);
        
    }
}
