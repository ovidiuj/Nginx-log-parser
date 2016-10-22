<?php

namespace Tests\Controller;


use Application\Request\HttpRequest;
use Application\Routing\Router;

class AbstractControllerTest extends \PHPUnit_Framework_TestCase
{
    private $request;

    private $router;

    private $app;

    private $controller;

    public function setUp()
    {
        parent::setUp();
        $server = [
            'REQUEST_URI' => '/',
            'REQUEST_METHOD' => 'GET'
        ];
        $this->request = $this->getMock('Application\Request\HttpRequest', [], [$server]);
        $this->router = new Router();
        $this->app = $this->getMock('Application\Application', [], [$this->router]);
        $this->controller = $this->getMockForAbstractClass('Controller\AbstractController', [$this->request, $this->app]);
    }

    public function testControllerParams() {
        $this->assertClassHasAttribute('request', 'Controller\AbstractController');
        $this->assertClassHasAttribute('app', 'Controller\AbstractController');
    }

    public function testGetRequest()
    {
        $this->assertInstanceOf(get_class($this->request), $this->controller->getRequest());
    }

    public function testGetApplication()
    {
        $this->assertInstanceOf(get_class($this->app), $this->controller->getApplication());
    }
}