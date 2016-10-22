<?php

namespace Application\Provider;


use Application\ContainerInterface;

/**
 * Class TwigServiceProvider
 * @package Application\Provider
 */
class TwigServiceProvider implements ServiceProviderInterface
{

    /**
     * @var string
     */
    private  $viewsPath = __DIR__ . '/../../views';
    /**
     * @var array
     */
    protected $twigParams;

    /**
     * TwigServiceProvider constructor.
     * @param array $params
     */
    public function __construct(array $params = array())
    {
        $this->twigParams = $params;
        if(isset($this->twigParams['path'])) {
            $this->viewsPath = $this->twigParams['path'];
        }

        if(!is_dir($this->viewsPath)) {
            throw new \Twig_Error_Loader(sprintf('The "%s" directory does not exist.', $this->viewsPath));
        }
    }

    /**
     * @param ContainerInterface $app
     */
    public function register(ContainerInterface $app)
    {
        if(empty($this->twigParams) || !isset($this->twigParams['path'])) {
            $app->container["twig-params"]['path'] = $this->viewsPath;
        } else {
            foreach ($this->twigParams as $key => $value) {
                $app->container["twig-params"][$key] = $value;
            }
        }

        $app->container['twig-params']['loader'] = new \Twig_Loader_Filesystem($app->container['twig-params']['path']);
        $app->container['twig'] = new \Twig_Environment($app->container['twig-params']['loader']);
        $app->container['twig']->addExtension(new \Twig_Extensions_Extension_Text());
    }

    /**
     * @return array
     */
    public function getTwigParams()
    {
        return $this->twigParams;
    }
}