<?php

namespace Application\Provider;


use Application\ContainerInterface;
use Application\Routing\Route;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlRoutingServiceProvider
 * @package Application\Provider
 */
class YamlRoutingServiceProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $file;

    /**
     * YamlRoutingServiceProvider constructor.
     * @param $file
     */
    public function __construct($file)
    {
        $this->file = $file;
        
        if(!file_exists($this->file)) {
            throw new \InvalidArgumentException(sprintf('The "%s" file does not exist.', $this->file));
        }
    }

    /**
     * @param ContainerInterface $app
     */
    public function register(ContainerInterface $app)
    {
        $config = Yaml::parse(file_get_contents($this->file));
        if (is_array($config)) {
            if (isset($app->container['routing']) && is_array($app->container['routing'])) {
                $app->container['routing'] = array_replace_recursive($app->container['routing'], $config);
            } else {
                $app->container['routing'] = $config;
            }
        }
        $this->addRoutes($app);
    }

    /**
     * @param $app
     */
    private function addRoutes($app)
    {
        foreach ($app->container['routing'] as $route) {
            $method = isset($route['method']) ? $route['method'] : 'GET';
            if (isset($route['defaults'])) {
                $controller = key($route['defaults']);
                $action = current($route['defaults']) . 'Action';
                $app->getRouter()->addRoute(
                    new Route($method, $route['path'], $controller, $action)
                );
            }
        }
    }

    /**
     * @return string
     */
    public function getRoutingFile()
    {
        return $this->file;
    }

}