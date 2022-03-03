<?php

namespace App\Http\Middleware;

use \Closure;
use \App\Http\Request;
use \App\Http\Response;
use \App\Session\Admin\Login as SessionAdminLogin;

class RequireAdminLogout
{
    /**
     * execute the middleware
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        //VERIFY IF THE USER IS LOGGED
        if (SessionAdminLogin::isLogged()) {
            $request->getRouter()->redirect("/admin");
        }

        //CONTINUE THE EXECUTION
        return $next($request);
    }
}
