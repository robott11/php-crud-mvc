<?php
namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;

class Router
{
    /**
     * entire project url (root)
     * @var string
     */
    private $url = "";

    /**
     * prefix of all routers
     * @var string
     */
    private $prefix = "";

    /**
     * route index
     * @var array
     */
    private $routes = [];

    /**
     * instance of Request
     * @var Request
     */
    private $request;

    /**
     * class constructor
     * @param string $url
     */
    function __construct(string $url)
    {
        $this->request = new Request($this);
        $this->url     = $url;
        $this->setPrefix();
    }

    /**
     * define the route prefix
     */
    private function setPrefix()
    {
        //URL INFO
        $parseUrl = parse_url($this->url);

        //DEFINE PREFIX
        $this->prefix = $parseUrl["path"] ?? "";
    }

    /**
     * this will add a route on the class
     * @param string $method
     * @param string $route
     * @param array  $params
     */
    private function addRoute(string $method, string $route, array $params = [])
    {
        //PARAMS VALIDATION
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params["controller"] = $value;
                unset($params[$key]);
                //continue;
            }
            //ROUTE VARS
            $params["variables"] = [];
            
            //STANDARD ROUTE VAR VALIDATION
            $patterVariable = "/{(.*?)}/";
            if (preg_match_all($patterVariable, $route, $matches)) {
                $route = preg_replace($patterVariable, "(.*?)", $route);
                $params["variables"] = $matches[1];
            }

            //STANDARD ROUTE VALIDATION
            $patternRoute = "/^".str_replace("/", "\/", $route)."$/";
            //ADD THE ROUTE TO THE CLASS
            $this->routes[$patternRoute][$method] = $params;
        }
    }

    /**
     * this will define a GET route
     * @param  string $route
     * @param  array $params
     */
    public function get(string $route, array $params = [])
    {
        $this->addRoute("GET", $route, $params);
    }

    /**
     * this will define a POST route
     * @param  string $route
     * @param  array $params
     */
    public function post(string $route, array $params = [])
    {
        $this->addRoute("POST", $route, $params);
    }

    /**
     * this will define a PUT route
     * @param  string $route
     * @param  array $params
     */
    public function put(string $route, array $params = [])
    {
        $this->addRoute("PUT", $route, $params);
    }

    /**
     * this will define a DELETE route
     * @param  string $route
     * @param  array $params
     */
    public function delete(string $route, array $params = [])
    {
        $this->addRoute("DELETE", $route, $params);
    }

    /**
     * returns the uri whitout prefix
     * @return string
     */
    private function getUri(): string
    {
        //REQUEST URI
        $uri = $this->request->getUri();

        //SPLIT THE URI WITH PREFIX
        //todo change srtlen to isset
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        return end($xUri);
    }

    /**
     * gets the current route data
     * @return array
     */
    private function getRoute()
    {
        //URI
        $uri = $this->getUri();

        //METHOD
        $httpMethod = $this->request->getHttpMethod();
        //VALIDATES ROUTES
        foreach ($this->routes as $patternRoute => $method) {
            //VERIFY IF ROUTE MATCHES PATTERN
            if (preg_match($patternRoute, $uri, $matches)) {
                //VERIFY METHOD
                if (isset($method[$httpMethod])) {
                    unset($matches[0]);

                    //PROCESSED VARIABLES
                    $keys = $method[$httpMethod]["variables"];
                    $method[$httpMethod]["variables"] = array_combine($keys, $matches);
                    $method[$httpMethod]["variables"]["request"] = $this->request;

                    //RETURNS THE ROUTE PARAMS
                    return $method[$httpMethod];
                }
                //METHOD UNDEFINED
                throw new Exception("Método não é permitido", 405);
            }
        }
        //URL NOT FOUND
        throw new Exception("URL não encontrada", 404);
    }

    /**
     * will execute the actual route
     * @return Response
     */
    public function run()
    {
        try {
            //GET THE CURRENT ROUTE
            $route = $this->getRoute();

            //VERIFY THE CONTROLLER EXISTS
            if(!isset($route["controller"])) {
                throw new Exception("A URL não pôde ser processada", 500);
            }

            //ARGS OF THE FUNCTION
            $args = [];

            //REFLECTION
            $reflection = new ReflectionFunction($route["controller"]);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route["variables"][$name] ?? "";
            }

            //RETURNS THE FUNCTION EXECUTION
            return call_user_func_array($route["controller"], $args);
        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }

    }

    /**
     * returns the current URL
     *
     * @return string
     */
    public function getCurrentUrl(): string
    {
        return $this->url.$this->getUri();
    }
}
