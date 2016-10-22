<?php

namespace Application\Provider;

use Application\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlConfigServiceProvider
 * @package Application\Provider
 */
class YamlConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $file;

    /**
     * YamlConfigServiceProvider constructor.
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
            if (isset($app->container['config']) && is_array($app->container['config'])) {
                $app->container['config'] = array_replace_recursive($app->container['config'], $config);
            } else {
                $app->container['config'] = $config;
            }
        }
    }

    /**
     * @return string
     */
    public function getConfigFile()
    {
        return $this->file;
    }
}