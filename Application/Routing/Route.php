<?php

namespace Application\Routing;


use Application\Request\HttpRequestInterface;

/**
 * Class Route
 * @package Application\Routing
 */
class Route
{
    /**
     * @var string
     */
    private $method = 'GET';

    /**
     * @var string
     */
    private $path = '';

    /**
     * @var array
     */
    private $routeParams = [];

    /**
     * @var string
     */
    private $controller;

    /**
     * @var string
     */
    private $action;

    /**
     * Route constructor.
     * @param $method
     * @param $path
     * @param $controller
     * @param $action
     */
    public function __construct($method, $path, $controller, $action)
    {
        $this->method = $method;
        $this->path = $path;
        $this->controller = $controller;
        $this->action = $action;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->routeParams;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getControllerAction()
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getMethod() 
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param HttpRequestInterface $request
     * @return bool
     */
    public function matches(HttpRequestInterface $request)
    {
        return strtoupper($this->method) == strtoupper($request->getMethod()) && $this->compileRoutePattern($request, $this->path);
    }

    /**
     * @param HttpRequestInterface $request
     * @param $pattern
     * @return bool
     */
    protected function compileRoutePattern(HttpRequestInterface &$request, $pattern)
    {
        $path = $request->getPath();
        $params = [];
        $pathComponents = array_filter(explode('/', $path), 'strlen');
        $patternsComponents = array_filter(explode('/', $pattern), 'strlen');

        if (count($pathComponents) != count($patternsComponents)) {
            return false;
        }
        $values = array_diff($pathComponents, $patternsComponents);
        $vars = array_diff($patternsComponents, $pathComponents);
        preg_match_all('#\{\w+\}#', $pattern, $patternVars, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);

        foreach ($patternVars as $match) {
            if ($key = array_search($match[0][0], $vars)) {
                $params[substr($match[0][0], 1, -1)] = $values[$key];
            }
        }
        $request->setParameters($params);
        return true;
    }
}