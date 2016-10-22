<?php

namespace Application\Response;

/**
 * Class JsonResponse
 * @package Application\Response
 */
class JsonResponse implements ResponseInterface
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
     * JsonResponse constructor.
     * @param $statusCode
     * @param array $body
     */
    public function __construct($statusCode = 200, $body = null)
    {
        if (null === $body) {
            $body = new \ArrayObject();
        }

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
        return json_encode($this->body);
    }
    
    /**
     *
     */
    public function flush()
    {
        http_response_code($this->statusCode);
        header('Content-type: application/json');
        echo $this->getContent();
    }


}