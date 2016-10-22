<?php
namespace Application\Tests;
use Application\Application;
use Application\Provider\TwigServiceProvider;
use Application\Routing\Router;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    private $router;

    private $provider;

    public function setUp()
    {
        parent::setUp();

        $this->router = new Router();
        $this->provider = new TwigServiceProvider();
    }

    public function testRegister() {
        $app = new Application($this->router);
        $this->assertInstanceOf('Application\Application', $app->register($this->provider));
        $this->assertInstanceOf('Twig_Environment', $app->container['twig']);
    }

    public function testGet() {
        $app = new Application($this->router);
        $app->register($this->provider);
        $this->assertInstanceOf('Twig_Environment', $app->get('twig'));
    }

    public function testGetWhenDoesNotExist() {
        $app = new Application($this->router);
        $app->register($this->provider);
        $this->assertSame(null, $app->get('test'));
    }

}