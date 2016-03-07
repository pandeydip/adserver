<?php

namespace Adition\ApiBundle\Controller;

use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Adition\CoreBundle\Auth\AuthenticatedUserTrait;

class ContentUnitController extends AbstractRestController
{

    use AuthenticatedUserTrait;

    /**
     * @param Request $request
     * @return Response
     *
     */
    public function getAction(Request $request)
    {
        $user = $this->getAuthUser($request);
        $data = $this->container->get('adition.content_unit')->get($request->get('id'), $user);

        return $this->response(['message' => $data['message']], $data['statusCode']);
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function postAction(Request $request)
    {
        $user = $this->getAuthUser($request);

        $data = $this->container->get('adition.content_unit')->create($request->request->all(), $user);

        return $this->response($data, Codes::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function deleteAction(Request $request)
    {
        $user = $this->getAuthUser($request);

        $data = $this->container->get('adition.content_unit')->delete($request->get('id'), $user);

        return $this->response(['message' => $data['message']], $data['statusCode']);
    }
}
