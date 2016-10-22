<?php

namespace Application\Response;

/**
 * Class Response
 * @package Application\Response
 */
class Response implements ResponseInterface
{

    /**
     * @var array
     */
    private $body = [];

    /**
     * @var int
     */
    private $statusCode = 200;

    /**
     * Response constructor.
     * @param $statusCode
     * @param $body
     */
    public function __construct($statusCode = 200, $body = null)
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     *
     */
    public function getContent()
    {
        return $this->body;
    }

    /**
     * 
     */
    public function flush()
    {
        http_response_code($this->statusCode);
        header('Content-type: text/html');
        echo $this->getContent();
    }

}