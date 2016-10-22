<?php

namespace Application\Tests\Provider;


use Application\Application;
use Application\Provider\YamlRoutingServiceProvider;
use Application\Routing\Router;
use Psr\Log\InvalidArgumentException;

class YamlRoutingServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    private $file = __DIR__ . '/../../../app/config/routing.yml';

    private $app;

    private $router;

    public function setUp()
    {
        parent::setUp();
        $this->router = new Router();
        $this->app = new Application($this->router);
    }

    public function testConstructor()
    {
        $provider = new YamlRoutingServiceProvider($this->file);
        $this->assertInternalType('string', $provider->getRoutingFile());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorWithWrongPath()
    {
        new YamlRoutingServiceProvider('test.yml');
    }

    public function testRegister()
    {
        $provider = new YamlRoutingServiceProvider($this->file);
        $provider->register($this->app);
        $routes = $this->router->getRoutes();
        $this->assertInternalType('array', $this->app->container['routing']);
        $this->assertInternalType('array', $routes);
        $this->assertInstanceOf('Application\Routing\Route', reset($routes));
    }
}