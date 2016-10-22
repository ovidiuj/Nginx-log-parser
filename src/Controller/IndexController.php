<?php
namespace Controller;


use Application\Response\JsonResponse;
use Application\Response\Response;

/**
 * Class IndexController
 * @package Controller
 */
class IndexController extends AbstractController
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $html = $this->app->get('twig')->render('index.twig');
        return new Response(200, $html);
    }

    /**
     * @return Response
     */
    public function jsonAction()
    {
        try {
            $parser = $this->app->get('nginx-log-parser');
            $response = $parser->parse();
            return new JsonResponse(200, $response);
        }
        catch (\Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}