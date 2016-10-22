<?php

namespace Application\Tests\Provider;


use Application\Provider\YamlConfigServiceProvider;
use Psr\Log\InvalidArgumentException;

class YamlConfigServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    private $app;
    
    private $file = __DIR__ . '/../../../app/config/services.yml';
    
    public function setUp()
    {
        parent::setUp();
        $router = $this->getMock('Application\Routing\Router');
        $this->app = $this->getMock('Application\Application', [], [$router]);
    }

    public function testConstructor()
    {
        $provider = new YamlConfigServiceProvider($this->file);
        $this->assertInternalType('string', $provider->getConfigFile());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorWithWrongPath()
    {
        new YamlConfigServiceProvider('test.yml');
    }

    public function testRegister()
    {
        $provider = new YamlConfigServiceProvider($this->file);
        $provider->register($this->app);
        $this->assertInternalType('array', $this->app->container['config']);
    }
}