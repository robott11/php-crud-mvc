<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Http\Request;
use \App\Model\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page
{
    /**
     * gets the testimonies itens
     *
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getTestimonyItens(Request $request, &$obPagination): string
    {
        //TESTIMONIES
        $itens = "";

        //TOTAL RECORDS
        $totalAmount = EntityTestimony::getTestimonies(null, null, null, "COUNT(*) as qtd")->fetchObject()->qtd;
        
        //CURRENT PAGE
        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams["page"] ?? 1;
        
        //PAGINATION INSTANCE
        $obPagination = new Pagination($totalAmount, $currentPage, 2);

        //PAGE RESULTS
        $results = EntityTestimony::getTestimonies(null, "id DESC", $obPagination->getLimit());

        //RENDERS THE ITEM
        while ($obTestimony = $results->fetchObject(EntityTestimony::class)) {
            $itens .= View::render("pages/testimony/item", [
                "name"    => $obTestimony->nome,
                "message" => $obTestimony->mensagem,
                "date"    => date("d/m/Y H:i:s", strtotime($obTestimony->data))
            ]);
        }

        //RETURNS THE TESTIMONIES
        return $itens;
    }

    /**
     * Method responsible for returning the content(view) of the testimonies
     * page
     * 
     * @param Request $request
     * @return string
     */
    public static function getTestimonies(Request $request): string
    {
        //TESTIMONY VIEW
        $content = View::render("pages/testimonies", [
            "itens"      => self::getTestimonyItens($request, $obPagination),
            "pagination" => parent::getPagination($request, $obPagination)
        ]);

        //PAGE VIEW
        return parent::getPage("Depoimentos", $content);
    }

    /**
     * register a testimony
     *
     * @param Request $request
     * @return string
     */
    public static function insertTestimony(Request $request): string
    {
        //POST DATA
        $postVars = $request->getPostVars();

        //TESTIMONY INSTANCE
        $obTestimony = new EntityTestimony();

        //REGISTER A TESTIMONY
        $obTestimony->nome    = $postVars["name"];
        $obTestimony->mensagem = $postVars["message"];
        $obTestimony->register();

        //RETURNS THE PAGE
        return self::getTestimonies($request);
    }
}
