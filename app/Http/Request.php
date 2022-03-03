<?php

namespace App\Http;

use \App\Http\Router;

class Request
{
    /**
     * router instance
     *
     * @var Router
     */
    private $router;

    /**
     * request HTTP method
     * 
     * @var string
     */
    private $httpMethod;

    /**
     * page URI
     * 
     * @var string
     */
    private $uri;

    /**
     * url params ($_GET)
     * 
     * @var array
     */
    private $queryParams = [];

    /**
     * received variables from page POST ($_POST)
     * 
     * @var array
     */
    private $postVars = [];

    /**
     * request header
     * 
     * @var array
     */
    private $headers = [];

    /**
     * initiate class and set values
     */
    public function __construct(Router $router)
    {
        $this->router      = $router;
        $this->queryParams = $_GET ?? [];
        $this->postVars    = $_POST ?? [];
        $this->headers     = getallheaders();
        $this->httpMethod  = $_SERVER["REQUEST_METHOD"] ?? "";
        $this->setUri();
    }

    /**
     * defines the URI
     *
     * @return void
     */
    private function setUri()
    {
        //COMPLETE URI
        $this->uri = $_SERVER["REQUEST_URI"] ?? "";

        //REMOVE URI GETS
        $xUri = explode("?", $this->uri);
        $this->uri = $xUri[0];
    }

    /**
     * returns the router instance
     *
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * request HTTP method getter
     * 
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * request uri getter
     * 
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * request headers getter
     * 
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * GET params getter
     * 
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * POST variables getter
     * 
     * @return array
     */
    public function getPostVars(): array
    {
        return $this->postVars;
    }
}
