<?php
namespace Application\Tests\Response;

use Application\Response\JsonResponse;

class JsonResponseTest extends  \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    public function testConstructorEmptyCreatesJsonObject()
    {
        $response = new JsonResponse();
        $this->assertSame('{}', $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
        $this->assertInstanceOf('Application\Response\JsonResponse', $response);
    }

    public function testConstructorWithArrayCreatesJsonArray()
    {
        $response = new JsonResponse(200, [0, 1, 2, 3]);
        $this->assertEquals('[0,1,2,3]', $response->getContent());
        $this->assertSame(200, $response->getStatusCode());
        $this->assertInstanceOf('Application\Response\JsonResponse', $response);
    }

    public function testConstructorWithAssocArrayCreatesJsonObject()
    {
        $response = new JsonResponse(200, array('foo' => 'bar'));
        $this->assertSame('{"foo":"bar"}', $response->getContent());
        $this->assertInstanceOf('Application\Response\JsonResponse', $response);
    }

    public function testConstructorWithSimpleTypes()
    {
        $response = new JsonResponse(200, 'foo');
        $this->assertSame('"foo"', $response->getContent());

        $response = new JsonResponse(200, 0);
        $this->assertSame('0', $response->getContent());

        $response = new JsonResponse(200, 0.1);
        $this->assertSame('0.1', $response->getContent());

        $response = new JsonResponse(200, true);
        $this->assertSame('true', $response->getContent());
    }
}