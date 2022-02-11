<?php
namespace App\Http\Middleware;

class Queue
{
    /**
     * 
     *
     * @var array
     */
    private static $map = [];

    /**
     * default middlewares
     *
     * @var array
     */
    private static $default = [];

    /**
     * middlewares queue
     *
     * @var array
     */
    private $middlewares = [];

    /**
     * controller execution
     *
     * @var Closure
     */
    private $controller;

    /**
     * controller arguments
     *
     * @var array
     */
    private $controllerArgs =[];

    /**
     * constructor of the queue middlewares 
     *
     * @param array $middlewares
     * @param Closure $controller
     * @param array $controllerArgs
     */
    public function __construct(array $middlewares, object $controller, array $controllerArgs)
    {
        $this->middlewares    = array_merge(self::$default, $middlewares);
        $this->controller     = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    /**
     * defines mapping of middlewares
     *
     * @param array $map
     * @return void
     */
    public static function setMap(array $map): void
    {
        self::$map = $map;
    }

    /**
     * defines default middlewares
     *
     * @param array $default
     * @return void
     */
    public static function setDefault(array $default): void
    {
        self::$default = $default;
    }

    /**
     * responsible method for executing the next middleware queue level
     *
     * @param object $request
     * @return Response
     */
    public function next(object $request)
    {
        //IF THE QUEUE IS EMPTY
        if (empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);

        //MIDDLEWARE
        $middleware = array_shift($this->middlewares);

        //VERIFY THE MAPPING
        if (!isset(self::$map[$middleware])) {
            throw new \Exception("Problemas ao processar o middleware da requisição", 500);
        }

        //NEXT
        $queue = $this;
        $next  = function($request) use($queue) {
            return $queue->next($request);
        };

        return (new self::$map[$middleware])->handle($request, $next);
    }
}
