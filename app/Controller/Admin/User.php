<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Http\Request;
use \App\Model\Entity\User as EntityUser;
use \WilliamCosta\DatabaseManager\Pagination;

class User extends Page
{
    /**
     * gets the user itens
     *
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getUserItens(Request $request, &$obPagination): string
    {
        //USERS
        $itens = "";

        //TOTAL RECORDS
        $totalAmount = EntityUser::getUsers(null, null, null, "COUNT(*) as qtd")->fetchObject()->qtd;
        
        //CURRENT PAGE
        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams["page"] ?? 1;
        
        //PAGINATION INSTANCE
        $obPagination = new Pagination($totalAmount, $currentPage, 5);

        //PAGE RESULTS
        $results = EntityUser::getUsers(null, "id DESC", $obPagination->getLimit());

        //RENDERS THE ITEM
        while ($obUsers = $results->fetchObject(EntityUser::class)) {
            $itens .= View::render("admin/modules/users/item", [
                "id"    => $obUsers->id,
                "name"  => $obUsers->nome,
                "email" => $obUsers->email
            ]);
        }

        //RETURNS THE USERS
        return $itens;
    }

    /**
     * Method responsible for returning the content(view) of the users 
     * admin page
     *
     * @param Request $request
     * @return string
     */
    public static function getUsers(Request $request): string
    {
        //HOME CONTENT
        $content = View::render("admin/modules/users/index", [
            "itens"      => self::getUserItens($request, $obPagination),
            "pagination" => parent::getPagination($request, $obPagination),
            "status"     => self::getStatus($request)
        ]);

        //RETURN THE PAGE
        return parent::getPanel("Admin - Usuários", $content, "users");
    }

    /**
     * returns the new user register form
     *
     * @param Request $request
     * @return string
     */
    public static function getNewUser(Request $request): string
    {
        //FORM CONTENT
        $content = View::render("admin/modules/users/form", [
            "title"  => "Cadastrar usuário",
            "name"   => "",
            "email"  => "",
            "status" => self::getStatus($request)
        ]);

        //RETURN THE PAGE
        return parent::getPanel("Admin - Cadastrar usuário", $content, "users");
    }

    /**
     * register a new admin user on the database
     *
     * @param Request $request
     * @return string
     */
    public static function setNewUser(Request $request)
    {
        //POST VARS
        $postVars = $request->getPostVars();
        $email    = $postVars["email"]    ?? "";
        $name     = $postVars["name"]     ?? "";
        $password = $postVars["password"] ?? "";
        
        //VALIDATE THE EMAIL
        $obUser = EntityUser::getUserByEmail($email);
        if ($obUser instanceof EntityUser) {
            //REDIRECT THE USER
            $request->getRouter()->redirect("/admin/users/new?status=duplicated");
        }

        //USER MODEL INSTANCE
        $obUser = new EntityUser();
        $obUser->nome  = $name     ?? "";
        $obUser->email = $email    ?? "";
        $obUser->senha = password_hash($password, PASSWORD_DEFAULT);
        $obUser->register();

        //REDIRECT THE USER
        $request->getRouter()->redirect("/admin/users/".$obUser->id."/edit?status=created");
    }

    /**
     * returns the status message
     *
     * @param Request $request
     * @return string
     */
    private static function getStatus(Request $request): string
    {
        //QUERY PARAMS
        $queryParams = $request->getQueryParams();

        //STATUS
        if (!isset($queryParams["status"])) return "";

        //STATUS MESSAGE
        switch ($queryParams["status"]) {
            case "created":
                return Alert::getSucess("Usuário criado com sucesso!");
                break;

            case "updated":
                return Alert::getSucess("Usuário atualizado com sucesso!");
                break;

            case "deleted":
                return Alert::getSucess("Usuário excluido com sucesso!");
                break;

            case "duplicated":
                return Alert::getError("E-mail já está sendo utilizado!");
                break;
        }
    }

    /**
     * returns the admin user edit form
     *
     * @param Request $request
     * @param int $int
     * @return string
     */
    public static function getEditUser(Request $request, int $id): string
    {
        //GETS THE USER FROM DB
        $obUser = EntityUser::getUserById($id);
        
        //VERIFY THE INSTANCE
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect("/admin/users");
        }

        //FORM CONTENT
        $content = View::render("admin/modules/users/form", [
            "title"  => "Editar usuário",
            "name"   => $obUser->nome,
            "email"  => $obUser->email,
            "status" => self::getStatus($request)
        ]);

        //RETURN THE PAGE
        return parent::getPanel("Admin - Editar usuário", $content, "users");
    }

    /**
     * updates a admin user
     *
     * @param Request $request
     * @param int $int
     * @return string
     */
    public static function setEditUser(Request $request, int $id): string
    {
        //GETS THE USER FROM DB
        $obUser = EntityUser::getUserById($id);
        
        //VERIFY THE INSTANCE
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect("/admin/users");
        }

        //POST VARS
        $postVars = $request->getPostVars();
        $email    = $postVars["email"]    ?? "";
        $name     = $postVars["name"]     ?? "";
        $password = $postVars["password"] ?? "";

        //VALIDATE THE EMAIL
        $obUserEmail = EntityUser::getUserByEmail($email);
        if ($obUserEmail instanceof EntityUser && $obUserEmail->id != $id) {
            //REDIRECT THE USER
            $request->getRouter()->redirect("/admin/users/".$id."/edit?status=duplicated");
        }

        //UPDATE THE USER INSTANCE
        $obUser->nome  = $name;
        $obUser->email = $email;
        $obUser->senha = password_hash($password, PASSWORD_DEFAULT);
        $obUser->update();

        //REDIRECT THE USER
        $request->getRouter()->redirect("/admin/users/".$obUser->id."/edit?status=updated");
    }

    /**
     * returns the user delete form
     *
     * @param Request $request
     * @param int $int
     * @return string
     */
    public static function getDeleteUser(Request $request, int $id): string
    {
        //GETS THE USER FROM DB
        $obUser = EntityUser::getUserById($id);
        
        //VERIFY THE INSTANCE
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect("/admin/users");
        }

        //FORM CONTENT
        $content = View::render("admin/modules/users/delete", [
            "name"  => $obUser->nome,
            "email" => $obUser->email
        ]);

        //RETURN THE PAGE
        return parent::getPanel("Admin - Excluir usuário", $content, "users");
    }

    /**
     * deletes a testimony
     *
     * @param Request $request
     * @param int $int
     * @return string
     */
    public static function setDeleteUser(Request $request, int $id): string
    {
        //GETS THE USER FROM DB
        $obUser = EntityUser::getUserById($id);
        
        //VERIFY THE INSTANCE
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect("/admin/users");
        }

        //DELETES THE USER
        $obUser->delete();

        //REDIRECT THE USER
        $request->getRouter()->redirect("/admin/users?status=deleted");
    }
}
