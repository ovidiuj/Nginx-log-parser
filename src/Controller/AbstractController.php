<?php

namespace Controller;


use Application\ContainerInterface;
use Application\Request\HttpRequestInterface;

/**
 * Class AbstractController
 * @package Controller
 */
abstract class AbstractController
{
    /**
     * @var ContainerInterface
     */
    protected $app;

    /**
     * @var HttpRequestInterface
     */
    protected $request;

    /**
     * AbstractController constructor.
     * @param HttpRequestInterface $request
     * @param ContainerInterface $app
     */
    public function __construct(HttpRequestInterface $request, ContainerInterface $app)
    {
        $this->app = $app;
        $this->request = $request;
    }

    /**
     * @return HttpRequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ContainerInterface
     */
    public function getApplication()
    {
        return $this->app;
    }
}