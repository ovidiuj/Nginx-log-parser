<?php

namespace Services;

/**
 * Interface ParserInterface
 * @package Services
 */
interface ParserInterface
{

    /**
     * @return mixed
     */
    public function parse();

    /**
     * @return mixed
     */
    public function getPatterns();
}