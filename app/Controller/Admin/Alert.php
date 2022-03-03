<?php

namespace App\Controller\Admin;

use \App\Utils\View;

class Alert
{
    /**
     * returns an sucess message
     *
     * @param string $message
     * @return string
     */
    public static function getSucess(string $message): string
    {
        return View::render("admin/alert/status", [
            "type"    => "success",
            "message" => $message
        ]);
    }

    /**
     * returns an error message
     *
     * @param string $message
     * @return string
     */
    public static function getError(string $message): string
    {
        return View::render("admin/alert/status", [
            "type"    => "danger",
            "message" => $message
        ]);
    }
}
