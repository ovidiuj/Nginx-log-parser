<?php

namespace Application\Request;

/**
 * Interface HttpRequestInterface
 * @package Application\Request
 */
interface HttpRequestInterface
{
    /**
     * @return mixed
     */
    public function getPath();

    /**
     * @return mixed
     */
    public function getMethod();
}