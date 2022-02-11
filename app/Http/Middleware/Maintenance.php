<?php
namespace App\Http\Middleware;

class Maintenance 
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
        //CHECK IF IT IS UNDER MAINTENANCE
        if (getenv("MAINTENANCE") == "true") {
            throw new \Exception("Página em manutenção. Tente novamente mais tarde.", 200);
        }

        //EXECUTE THE NEXT MIDDLEWARE LAYER
        return $next($request);
    }
}
