<?php

namespace App\Session\Admin;

use \App\Model\Entity\User;

class Login
{
    /**
     * initiates the session
     *
     * @return void
     */
    private static function init(): void
    {
        //VERIFY THE SESSION
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * set the user session
     *
     * @param User $obUser
     * @return bool
     */
    public static function login(User $obUser): bool
    {
        //START THE SESSION
        self::init();

        $_SESSION["admin"]["user"] = [
            "id"    => $obUser->id,
            "name"  => $obUser->nome,
            "email" => $obUser->email
        ];

        //SUCESS
        return true;
    }

    /**
     * verify if the user is logged
     *
     * @return bool
     */
    public static function isLogged(): bool
    {
        //START THE SESSION
        self::init();

        //RETURN THE VERIFICATION
        return isset($_SESSION["admin"]["user"]["id"]);
    }

    /**
     * unset the user session
     *
     * @return bool
     */
    public static function logout(): bool
    {
        //START THE SESSION
        self::init();

        //LOGOUT THE USER
        unset($_SESSION["admin"]["user"]);

        //SUCESS
        return true;
    }
}
