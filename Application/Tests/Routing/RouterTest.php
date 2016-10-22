<?php

namespace Application\Tests\Routing;


use Application\Request\HttpRequest;
use Application\Routing\Route;
use Application\Routing\Router;
use Application\Routing\RoutingException;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    private $request;

    private $router;

    private $route;

    public function setUp()
    {
        parent::setUp();
        $server = [
            'REQUEST_URI' => '/random-generator/300/EOT',
            'REQUEST_METHOD' => 'GET'
        ];
        $this->request = new HttpRequest($server);
        $this->router = new Router();
        $this->route = new Route('get', '/random-generator/{length}/{chars}', 'IndexController', 'index');
    }

    public function testAddRoute()
    {
        $this->router->addRoute($this->route);
        $routes = $this->router->getRoutes();
        $this->assertInternalType('array', $routes);
        $this->assertInstanceOf('Application\Routing\Route', reset($routes));
    }

    public function testRouteMethod()
    {
        $this->router->addRoute($this->route);
        $this->assertInstanceOf('Application\Routing\Route', $this->router->route($this->request));
    }

    /**
     * @expectedException \Exception
     */
    public function testRouteMethodWhenRouteDoesNotMatches()
    {
        $this->router->addRoute($this->route);
        $server = [
            'REQUEST_URI' => '/random-generator/EOT',
            'REQUEST_METHOD' => 'GET'
        ];
        $request = new HttpRequest($server);
        $this->router->route($request);
    }
}