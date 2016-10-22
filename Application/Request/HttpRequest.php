<?php
namespace Application\Request;

/**
 * Class HttpRequest
 * @package Application\Request
 */
class HttpRequest implements HttpRequestInterface
{
    /**
     * @var array
     */
    private $server = [];

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * HttpRequest constructor.
     * @param array $server
     */
    public function __construct(array $server)
    {
        $this->server = $server;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return parse_url($this->server['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     * @return mixed|string
     */
    public function getMethod()
    {
        return mb_strtolower($this->server['REQUEST_METHOD']);
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }
}