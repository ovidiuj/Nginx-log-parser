<?php

namespace Application;

use Application\Provider\ServiceProviderInterface;
use Application\Request\HttpRequestInterface;
use Application\Response\ResponseInterface;
use Application\Routing\Router;

/**
 * Class Application
 * @package Application
 */
class Application implements ContainerInterface
{
    /**
     * @var array
     */
    public $container = [];
    /**
     * @var Router
     */
    private $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param ServiceProviderInterface $provider
     * @param array $values
     * @return $this
     */
    public function register(ServiceProviderInterface $provider, array $values = array())
    {
        $provider->register($this);

        foreach ($values as $key => $value) {
            $this->container[$key] = $value;
        }

        return $this;
    }

    /**
     * @param $component
     * @return null|object
     */
    public function get($component)
    {
        return $this->parseContainer($this->container, $component);
    }

    /**
     * @param $container
     * @param $component
     * @return null|object
     */
    private function parseContainer($container, $component)
    {
        if (isset($container[$component])) {
            return $container[$component];
        } elseif (isset($container['config']['parameters'][$component])) {
            return $container['config']['parameters'][$component];
        } elseif (isset($container['config']['services'][$component])) {
            $service = $container['config']['services'][$component];

            if (isset($service['class'])) {
                $object = null;
                if (isset($service['arguments'])) {
                    $arguments = $this->parseServiceArguments($service['arguments']);
                    $refObj = new \ReflectionClass($service['class']);
                    $object = $refObj->newInstanceArgs($arguments);
                }

                if (isset($service['calls'])) {
                    $object = is_object($object) ? $object : new $service['class'];
                    $object = $this->invokeServiceCalls($object, $service['calls']);
                }

                if (!is_object($object)) {
                    $object = new $service['class'];
                }

                return $object;
            }
        }
        return null;
    }

    /**
     * @param $arguments
     * @return array
     */
    private function parseServiceArguments($arguments)
    {
        $params = [];
        if (!empty($arguments) && is_array($arguments)) {
            foreach ($arguments as $arg) {
                if (preg_match('/\@\w+/', $arg)) {
                    if ($service = $this->get(substr($arg, 1, strlen($arg)))) {
                        $params[] = $service;
                    }
                } elseif (preg_match('/\%[a-zA-Z0-9\-\.\_]+\%/', $arg)) {
                    if ($param = $this->get(substr($arg, 1, strlen($arg) - 2))) {
                        $params[] = $param;
                    }
                }
            }
        }
        return $params;
    }

    /**
     * @param $object
     * @param $calls
     * @return mixed
     */
    private function invokeServiceCalls($object, $calls)
    {
        foreach ($calls as $call) {
            foreach ($call as $method => $params) {
                if (method_exists($object, $method)) {
                    $object->$method($params);
                }
            }
        }
        return $object;
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param HttpRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function run(HttpRequestInterface $request)
    {
        $route = $this->router->route($request);
        $controller = $route->getController();
        $action = $route->getControllerAction();
        $reflectionMethod = new \ReflectionMethod($controller, $action);
        $response = $reflectionMethod->invoke(new $controller($request, $this), $action);
        return $response;
    }
}