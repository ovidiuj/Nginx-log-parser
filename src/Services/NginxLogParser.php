<?php

namespace Services;


use Application\ServiceInterface;
use Entities\NginxLog;

/**
 * Class NginxLogParser
 * @package Services
 */
class NginxLogParser implements ServiceInterface, ParserInterface
{
    /**
     * @var string
     */
    private $logPath;

    /**
     * @var string
     */
    private $country;

    /**
     * @var array
     */
    private $patterns = [
        '(?P<remoteAddress>(\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3}))',
        '(?P<serverName>([a-z0-9.-]*))',
        '(?P<remoteUser>(:-|[\w-]+))',
        '\[(?P<timeLocal>(\d{2}\/(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\/\d{4}:\d{2}:\d{2}:\d{2}\s(?:-|\+)\d{4}))\]',
        '(?P<request>(\"(GET|POST|PUT|PATCH|HEAD|OPTIONS)\s(.+)\s(http\/1\.1)\"))',
        '(?P<status>(\d{3}|-))',
        '(?P<bodyBytesSent>([0-9]+))',
        '(?P<httpReferer>(\".*?\"))',
        '(?P<httpUserAgent>(\".*?\"))',
    ];

    /**
     * NginxLogParser constructor.
     * @param $logPath
     * @param null $country
     */
    public function __construct($logPath, $country = null)
    {
        $this->logPath = $logPath;
        $this->country = $country;
    }

    /**
     * @return array
     */
    public function getPatterns()
    {
        return $this->patterns;
    }

    /**
     * @return string
     */
    public function getLogPath()
    {
        return $this->logPath;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function parse()
    {
        $nginxLogObjects = [];
        foreach ($this->getLines() as $line) {
            if($jsonObject = $this->parseLogLine($line)) {
                $nginxLogObjects[] = $jsonObject;
            }
        }
       
        return $nginxLogObjects;
    }

    /**
     * @param $line
     * @return NginxLog|null
     */
    private function parseLogLine($line)
    {
        $object = new NginxLog();
        $pattern = implode('\s', $this->getPatterns());
        preg_match('/' . $pattern . '/i', $line, $matches);

        foreach ($matches as $key => $match) {
            if(property_exists($object, $key) !== false) {
                $object->$key = $match;
            }
        }

        if(!$this->validateCountry($object->remoteAddress)){
            return null;
        }

        return $object;
    }

    /**
     * @return \Generator
     * @throws \Exception
     */
    private function getLines()
    {
        try {
            $f = fopen(__DIR__ . $this->logPath, 'r');
            while ($line = fgets($f)) {
                yield $line;
            }
            fclose($f);
        } catch (\Exception $e) {
            throw new ServiceException($this->logPath . "File doesn't exist");
        }
    }

    /**
     * @param $ip
     * @return bool
     */
    private function validateCountry($ip)
    {
        if($this->country) {
            return trim(file_get_contents("http://ipinfo.io/$ip/country/")) == $this->country;
        }
        return true;
    }

}