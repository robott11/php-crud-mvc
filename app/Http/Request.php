<?php
namespace App\Http;

class Request
{
    /**
     * request HTTP method
     * @var string
     */
    private $httpMethod;

    /**
     * page URI
     * @var string
     */
    private $uri;

    /**
     * url params ($_GET)
     * @var array
     */
    private $queryParams = [];

    /**
     * received variables from page POST ($_POST)
     * @var array
     */
    private $postVars = [];

    /**
     * request header
     * @var array
     */
    private $headers = [];

    /**
     * initiate class and set values
     */
    public function __construct()
    {
        $this->queryParams = $_GET ?? [];
        $this->queryParams = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER["REQUEST_METHOD"] ?? "";
        $this->uri = $_SERVER["REQUEST_URI"] ?? "";
    }

    /**
     * request HTTP method getter
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * request uri getter
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * request headers getter
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * GET params getter
     * @return array
     */
    public function getQeuryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * POST variables getter
     * @return array
     */
    public function getPostVars(): array
    {
        return $this->postVars;
    }
}
