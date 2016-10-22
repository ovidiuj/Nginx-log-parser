<?php

namespace Application\Tests\Provider;


use Application\Provider\TwigServiceProvider;

class TwigServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    private $app;
    
    public function setUp()
    {
        parent::setUp();
        $router = $this->getMock('Application\Routing\Router');
        $this->app = $this->getMock('Application\Application', [], [$router]);
    }

    public function testConstructor()
    {
        $provider = new TwigServiceProvider();
        $this->assertInternalType('array', $provider->getTwigParams());
    }

    /**
     * @expectedException \Twig_Error_Loader
     */
    public function testConstructorWithWrongPath()
    {
        new TwigServiceProvider(['path' => '/test/']);
    }

    public function testRegister()
    {
        $provider = new TwigServiceProvider();
        $provider->register($this->app);
        $this->assertInternalType('array', $this->app->container["twig-params"]);
        $this->assertInstanceOf('Twig_Environment', $this->app->container['twig']);
    }
}