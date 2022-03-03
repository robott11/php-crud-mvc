<?php

namespace App\Http;

class Response
{
    /**
     * HTTP status code
     * 
     * @var int
     */
    private $httpCode = 200;

    /**
     * response header
     * 
     * @var array
     */
    private $headers = [];

    /**
     * Content type being returned
     * 
     * @var string
     */
    private $contentType = "text/html";

    /**
     * response content
     * 
     * @var mixed
     */
    private $content;

    /**
     * initiate class and set values
     * @param int    $httpCode
     * @param mixed  $content
     * @param string $contentType
     */
    public function __construct(
        int $httpCode,
        mixed $content,
        string $contentType = "text/html"
    ) {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    /**
     * set the content type of the response
     * 
     * @param string $contentType  [description]
     * @return void
     */
    public function setContentType(string $contentType): void
    {
        $this->contentType = $contentType;
        $this->addHeader("Content-Type", $contentType);
    }

    /**
     * add a value to header of the response
     * 
     * @param string $key
     * @param string $value
     * @return void
     */
    public function addHeader(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    /**
     * send headers to browser
     * 
     * @return void
     */
    private function sendHeaders(): void
    {
        //STATUS
        http_response_code($this->httpCode);

        //SEND HEADERS
        foreach ($this->headers as $key => $value) {
            header($key.": ".$value);
        }
    }

    /**
     * send reponse to user
     * 
     * @return void
     */
    public function sendResponse(): void
    {
        //SEND HEADERS
        $this->sendHeaders();

        //PRINT THE CONTENT
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                break;
        }
    }
}
