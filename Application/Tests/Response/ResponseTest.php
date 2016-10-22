<?php
namespace Application\Tests\Response;

use Application\Response\Response;

class ResponseTest extends  \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    public function testConstructorEmptyCreatesJsonObject()
    {
        $response = new Response();
        $this->assertSame(null, $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
        $this->assertInstanceOf('Application\Response\Response', $response);
    }

    public function testConstructorWithArrayCreatesJsonArray()
    {
        $response = new Response(200, [0, 1, 2, 3]);
        $this->assertEquals([0, 1, 2, 3], $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
        $this->assertInstanceOf('Application\Response\Response', $response);
    }

    public function testConstructorWithSimpleTypes()
    {
        $response = new Response(200, 'foo');
        $this->assertSame('foo', $response->getContent());

        $response = new Response(200, 0);
        $this->assertSame(0, $response->getContent());

        $response = new Response(200, 0.1);
        $this->assertSame(0.1, $response->getContent());

        $response = new Response(200, true);
        $this->assertSame(true, $response->getContent());
    }
}