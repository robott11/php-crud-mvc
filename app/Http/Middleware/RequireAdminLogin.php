<?php
namespace App\Http\Middleware;

use \App\Session\Admin\Login as SessionAdminLogin;

class RequireAdminLogin
{
    /**
     * execute the middleware
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(object $request, object $next): object
    {
        //VERIFY IF THE USER IS LOGGED
        if (!SessionAdminLogin::isLogged()) {
            $request->getRouter()->redirect("/admin/login");
        }

        //CONTINUE THE EXECUTION
        return $next($request);
    }
}
