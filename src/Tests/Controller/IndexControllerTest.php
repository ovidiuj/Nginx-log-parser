<?php
namespace Tests\Controller;


use Application\Application;
use Application\Request\HttpRequest;
use Application\Response\JsonResponse;
use Application\Response\Response;
use Application\Routing\Route;
use Application\Routing\Router;
use Controller\IndexController;

class IndexControllerTest extends \PHPUnit_Framework_TestCase
{
    private $request;

    private $router;

    private $route;

    private $app;

    private $controller;

    public function setUp()
    {
        parent::setUp();
        $server = [
            'REQUEST_URI' => '/',
            'REQUEST_METHOD' => 'GET'
        ];
        $this->request = new HttpRequest($server);
        $this->router = new Router();
        $this->route = new Route('get', '/random-generator/{length}/{chars}', 'IndexController', 'index');
        $this->app = new Application($this->router);
        $this->controller = new IndexController($this->request, $this->app);
    }

    public function testIndexAction()
    {
        $html = 'html';

        $template = $this->getMock('Twig_Environment');
        $template
            ->expects($this->once())
            ->method("render")
            ->with('index.twig', [])
            ->will($this->returnValue($html));

        $application = $this->getMock('Application\Application', [], [$this->router]);

        $application->expects($this->at(0))
            ->method("get")
            ->with("twig")
            ->will($this->returnValue($template));

        $controller = new IndexController($this->request, $application);
        $response = new Response(200, $html);

        $this->assertEquals($response, $controller->indexAction());
    }

    public function testJsonAction()
    {
        $json = "{}";
        $nginxLogParser = $this->getMock('Services\NginxLogParser', [], ['/../../nginx.log', 'DE']);

        $nginxLogParser
            ->expects($this->once())
            ->method('parse')
            ->will($this->returnValue($json));


        $application = $this->getMock('Application\Application', [], [$this->router]);
        $application->expects($this->at(0))
            ->method("get")
            ->with("nginx-log-parser")
            ->will($this->returnValue($nginxLogParser));

        $controller = new IndexController($this->request, $application);
        $response = new JsonResponse(200, $json);

        $this->assertEquals($response, $controller->jsonAction());
    }
}