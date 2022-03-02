<?php
namespace App\Controller\Admin;

use \App\Utils\View;
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
    private static function getTestimonyItens($request, &$obPagination): string
    {
        //TESTIMONIES
        $itens = "";

        //TOTAL RECORDS
        $totalAmount = EntityTestimony::getTestimonies(null, null, null, "COUNT(*) as qtd")->fetchObject()->qtd;
        
        //CURRENT PAGE
        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams["page"] ?? 1;
        
        //PAGINATION INSTANCE
        $obPagination = new Pagination($totalAmount, $currentPage, 5);

        //PAGE RESULTS
        $results = EntityTestimony::getTestimonies(null, "id DESC", $obPagination->getLimit());

        //RENDERS THE ITEM
        while ($obTestimony = $results->fetchObject(EntityTestimony::class)) {
            $itens .= View::render("admin/modules/testimonies/item", [
                "id"      => $obTestimony->id,
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
     * admin page
     *
     * @param Request $request
     * @return string
     */
    public static function getTestimonies(object $request): string
    {
        //HOME CONTENT
        $content = View::render("admin/modules/testimonies/index", [
            "itens"      => self::getTestimonyItens($request, $obPagination),
            "pagination" => parent::getPagination($request, $obPagination),
            "status"     => self::getStatus($request)
        ]);

        //RETURN THE PAGE
        return parent::getPanel("Admin - Depoimentos", $content, "testimonies");
    }

    /**
     * returns the testimony register form
     *
     * @param Request $request
     * @return string
     */
    public static function getNewTestimony(object $request): string
    {
        //FORM CONTENT
        $content = View::render("admin/modules/testimonies/form", [
            "title"   => "Cadastrar depoimento",
            "name"    => "",
            "message" => "",
            "status"  => ""
        ]);

        //RETURN THE PAGE
        return parent::getPanel("Admin - Cadastrar depoimento", $content, "testimonies");
    }

    /**
     * register a new testimony on the database
     *
     * @param Request $request
     * @return string
     */
    public static function setNewTestimony(object $request)
    {
        //POST VARS
        $postVars = $request->getPostVars();
        
        //TESTIMONY MODEL INSTANCE
        $obTestimony = new EntityTestimony();
        $obTestimony->nome     = $postVars["name"]    ?? "";
        $obTestimony->mensagem = $postVars["message"] ?? "";
        $obTestimony->register();

        //REDIRECT THE USER
        $request->getRouter()->redirect("/admin/testimonies/".$obTestimony->id."/edit?status=created");
    }

    /**
     * returns the status message
     *
     * @param object $request
     * @return string
     */
    private static function getStatus(object $request): string
    {
        //QUERY PARAMS
        $queryParams = $request->getQueryParams();

        //STATUS
        if (!isset($queryParams["status"])) return "";

        //STATUS MESSAGE
        switch ($queryParams["status"]) {
            case "created":
                return Alert::getSucess("Depoimento criado com sucesso!");
                break;

            case "updated":
                return Alert::getSucess("Depoimento atualizado com sucesso!");
                break;

            case "deleted":
                return Alert::getSucess("Depoimento excluido com sucesso!");
                break;
        }
    }

    /**
     * returns the testimony edit form
     *
     * @param Request $request
     * @param int $int
     * @return string
     */
    public static function getEditTestimony(object $request, int $id): string
    {
        //GETS THE TESTIMONY FROM DB
        $obTestimony = EntityTestimony::getTestimonyById($id);
        
        //VERIFY THE INSTANCE
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect("/admin/testimonies");
        }

        //FORM CONTENT
        $content = View::render("admin/modules/testimonies/form", [
            "title"   => "Editar depoimento",
            "name"    => $obTestimony->nome,
            "message" => $obTestimony->mensagem,
            "status"  => self::getStatus($request)
        ]);

        //RETURN THE PAGE
        return parent::getPanel("Admin - Editar depoimento", $content, "testimonies");
    }

    /**
     * updates a testimony
     *
     * @param Request $request
     * @param int $int
     * @return string
     */
    public static function setEditTestimony(object $request, int $id): string
    {
        //GETS THE TESTIMONY FROM DB
        $obTestimony = EntityTestimony::getTestimonyById($id);
        
        //VERIFY THE INSTANCE
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect("/admin/testimonies");
        }

        //POST VARS
        $postVars = $request->getPostVars();

        //UPDATE THE TESTIMONY INSTANCE
        $obTestimony->nome = $postVars["name"] ?? $obTestimony->nome;
        $obTestimony->mensagem = $postVars["message"] ?? $obTestimony->mensagem;
        $obTestimony->update();

        //REDIRECT THE USER
        $request->getRouter()->redirect("/admin/testimonies/".$obTestimony->id."/edit?status=updated");
    }

    /**
     * returns the testimony delete form
     *
     * @param Request $request
     * @param int $int
     * @return string
     */
    public static function getDeleteTestimony(object $request, int $id): string
    {
        //GETS THE TESTIMONY FROM DB
        $obTestimony = EntityTestimony::getTestimonyById($id);
        
        //VERIFY THE INSTANCE
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect("/admin/testimonies");
        }

        //FORM CONTENT
        $content = View::render("admin/modules/testimonies/delete", [
            "name"    => $obTestimony->nome,
            "message" => $obTestimony->mensagem
        ]);

        //RETURN THE PAGE
        return parent::getPanel("Admin - Excluir depoimento", $content, "testimonies");
    }

    /**
     * deletes a testimony
     *
     * @param Request $request
     * @param int $int
     * @return string
     */
    public static function setDeleteTestimony(object $request, int $id): string
    {
        //GETS THE TESTIMONY FROM DB
        $obTestimony = EntityTestimony::getTestimonyById($id);
        
        //VERIFY THE INSTANCE
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect("/admin/testimonies");
        }

        //DELETES THE TESTIMONY
        $obTestimony->delete();

        //REDIRECT THE USER
        $request->getRouter()->redirect("/admin/testimonies?status=deleted");
    }
}
