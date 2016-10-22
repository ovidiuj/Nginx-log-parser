<?php
namespace Application\Tests\Routing;

use Application\Request\HttpRequest;
use Application\Routing\Route;

class RouteTest extends \PHPUnit_Framework_TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();
        $server = [
            'REQUEST_URI' => '/random-generator/300/EOT',
            'REQUEST_METHOD' => 'GET'
        ];
        $this->request = new HttpRequest($server);
    }

    public function testConstructor()
    {
        $route = new Route('get', '/random-generator/{length}/{chars}', 'IndexController', 'index');
        $this->assertSame('get', $route->getMethod());
        $this->assertSame('/random-generator/{length}/{chars}', $route->getPath());
        $this->assertSame('IndexController', $route->getController());
        $this->assertSame('index', $route->getControllerAction());
    }

    public function testMatches()
    {
        $route = new Route('get', '/random-generator/{length}/{chars}', 'IndexController', 'index');
        $this->assertTrue($route->matches($this->request));
    }

    public function testDoesNotMatche()
    {
        $route = new Route('get', '/random-generator/{chars}', 'IndexController', 'index');
        $this->assertFalse($route->matches($this->request));
    }

}