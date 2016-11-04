<?php
namespace  Tests\Services;
use Services\ServiceException;

class NginxLogParserTest extends \PHPUnit_Framework_TestCase
{
    private  $logPath;

    public function setUp()
    {
        parent::setUp();
        $this->logPath = '/../../nginx.log';
    }
    
    public function testGetPatterns()
    {
        $nginxLogParser = $this->getMock('Services\NginxLogParser', ['getPatterns'], [$this->logPath, 'DE']);

        $nginxLogParser
            ->expects($this->once())
            ->method('getPatterns')
            ->will($this->returnValue([]));

        $this->assertInternalType('array', $nginxLogParser->getPatterns());
    }

    public function testGetLogPath()
    {
        $nginxLogParser = $this->getMock('Services\NginxLogParser', ['getLogPath'], [$this->logPath, 'DE']);

        $nginxLogParser
            ->expects($this->any())
            ->method('getLogPath')
            ->will($this->returnValue($this->logPath));

        $this->assertInternalType('string', $nginxLogParser->getLogPath());
        $this->assertEquals($this->logPath, $nginxLogParser->getLogPath());
    }

    public function testParse()
    {
        $nginxLogParser = $this->getMock('Services\NginxLogParser', ['parse'], [$this->logPath, 'DE']);

        $nginxLogParser
            ->expects($this->any())
            ->method('parse')
            ->will($this->returnValue([]));

        $this->assertInternalType('array', $nginxLogParser->parse());
    }
}