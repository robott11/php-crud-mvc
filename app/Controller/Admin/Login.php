<?php

namespace App\Controller\Admin;

use App\Utils\View;
use App\Http\Request;
use App\Model\Entity\User;
use App\Session\Admin\Login as SessionAdminLogin;

class Login extends Page
{
    /**
     * Method responsible for returning the content(view) of the admin login
     * page
     * 
     * @param Request $request
     * @param string $errorMessage
     * @return string
     */
    public static function getLogin(Request $request, string|null $errorMessage = null): string
    {
        //STATUS
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : "";

        //LOGIN PAGE CONTENT
        $content = View::render("admin/login", [
            "status" => $status
        ]);

        //RETURN THE PAGE
        return parent::getPage("Admin - Login", $content);
    }

    /**
     * login the user
     *
     * @param Request $request
     * @return string
     */
    public static function setLogin(Request $request): string
    {
        //POST VARS
        $postVars = $request->getPostVars();
        $email    = $postVars["email"] ?? "";
        $password = $postVars["password"] ?? "";

        //LOOK FOR THE USER BY EMAIL
        $obUser = User::getUserByEmail($email);
        if (!$obUser instanceof User) {
            return self::getLogin($request, "E-mail inválido");
        }

        //VERIFY THE PASSWORD
        if (!password_verify($password, $obUser->senha)) {
            return self::getLogin($request, "Senha inválida");
        }

        //CREATES THE LOGIN SESSION
        SessionAdminLogin::login($obUser);

        //REDIRECT THE USER TO THE ADMIN HOME
        $request->getRouter()->redirect("/admin");
    }

    /**
     * logout the user
     *
     * @param Request $request
     * @return void
     */
    public static function setLogout(Request $request): void
    {
        //DESTROY THE ADMIN USER SESSION
        SessionAdminLogin::logout();

        //REDIRECT THE USER
        $request->getRouter()->redirect("/admin/login");
    }
}
