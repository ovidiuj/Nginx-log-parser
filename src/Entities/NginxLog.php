<?php
namespace  Entities;

class NginxLog
{
    /**
     * @var string
     */
    public $remoteAddress;

    /**
     * @var string
     */
    public $serverName;

    /**
     * @var string
     */
    public $remoteUser;

    /**
     * @var string
     */
    public $timeLocal;

    /**
     * @var string
     */
    public $request;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $bodyBytesSent;

    /**
     * @var string
     */
    public $httpReferer;

    /**
     * @var string;
     */
    public $httpUserAgent;
}