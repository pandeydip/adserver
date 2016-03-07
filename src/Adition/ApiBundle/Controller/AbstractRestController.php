<?php

namespace Adition\ApiBundle\Controller;


use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;

abstract class AbstractRestController extends FOSRestController
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function getAction(Request $request)
    {
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function putAction(Request $request)
    {
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function postAction(Request $request)
    {
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function deleteAction(Request $request)
    {
    }

    /**
     * Gets an instance of the Container
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param mixed $data
     * @param int $statusCode
     * @return Response
     */
    protected function response($data, $statusCode = Codes::HTTP_OK)
    {
        $view = $this->view($data, $statusCode);

        return $this->handleView($view);
    }
}
