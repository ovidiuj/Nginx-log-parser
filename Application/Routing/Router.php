<?php

namespace Application\Routing;


use Application\Request\HttpRequestInterface;
use Application\Response\ResponseInterface;

/**
 * Class Router
 * @package Application\Routing
 */
class Router
{
    /**
     * @var array
     */
    private $routes = [];

    /**
     * @param Route $route
     */
    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    /**
     * @param HttpRequestInterface $request
     *
     * @return ResponseInterface
     * @throws RoutingException
     */
    public function route(HttpRequestInterface $request)
    {
        foreach ($this->routes as $route) {
            if (!$route->matches($request)) {
                continue;
            }
            return $route;
        }
        throw new RoutingException(
            sprintf('No route for %s %s', $request->getMethod(), $request->getPath())
        );
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}