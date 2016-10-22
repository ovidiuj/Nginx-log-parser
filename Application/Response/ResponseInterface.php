<?php

namespace Application\Response;

/**
 * Interface ResponseInterface
 * @package Application\Response
 */
interface ResponseInterface
{
    /**
     * Gets the response status code.
     *
     * The status code is a 3-digit integer result code of the server's attempt
     * to understand and satisfy the request.
     *
     * @return int Status code.
     */
    public function getStatusCode();

    /**
     * @return mixed
     */
    public function getContent();

    /**
     * @return mixed
     */
    public function flush();
}