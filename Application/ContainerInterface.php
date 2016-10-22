<?php

namespace Application;

;
use Application\Provider\ServiceProviderInterface;
use Application\Request\HttpRequestInterface;

/**
 * Interface ContainerInterface
 * @package Application
 */
interface ContainerInterface
{
    /**
     * @param ServiceProviderInterface $provider
     * @param array $values
     * @return mixed
     */
    public function register(ServiceProviderInterface $provider, array $values);

    /**
     * @param HttpRequestInterface $request
     * @return mixed
     */
    public function run(HttpRequestInterface $request);
}