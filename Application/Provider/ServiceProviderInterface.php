<?php

namespace Application\Provider;

use Application\ContainerInterface;

/**
 * Interface ServiceProviderInterface
 * @package Application\Provider
 */
interface ServiceProviderInterface
{
    /**
     * @param ContainerInterface $app
     * @return mixed
     */
    public function register(ContainerInterface $app);
}