<?php
namespace Application\Tests\Request;

use Application\Request\HttpRequest;

class HttpRequestTest extends \PHPUnit_Framework_TestCase
{
    private  $request;

    public function setUp()
    {
        parent::setUp();
        $server = [
            'REQUEST_URI' => '/random-generator/300/EOT',
            'REQUEST_METHOD' => 'GET'
        ];
        $this->request = new HttpRequest($server);
    }

    public function testConstruct()
    {
        $this->assertEquals('/random-generator/300/EOT', $this->request->getPath());
        $this->assertEquals('GET', strtoupper($this->request->getMethod()));
    }


    public function testGetParameters()
    {
        $this->assertEquals([], $this->request->getParameters());

        $this->request->setParameters(array('foo' => 'bar'));
        $this->assertEquals(['foo' => 'bar'], $this->request->getParameters());
    }
}