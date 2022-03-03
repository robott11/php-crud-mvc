<?php

namespace App\Http\Middleware;

use \Closure;
use \App\Http\Request;
use \App\Http\Response;

class Maintenance 
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
        //CHECK IF IT IS UNDER MAINTENANCE
        if (getenv("MAINTENANCE") == "true") {
            throw new \Exception("Página em manutenção. Tente novamente mais tarde.", 200);
        }

        //EXECUTE THE NEXT MIDDLEWARE LAYER
        return $next($request);
    }
}
