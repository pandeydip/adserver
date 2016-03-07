<?php

namespace Adition\ApiBundle\Controller;

use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Adition\CoreBundle\Auth\AuthenticatedUserTrait;

class CampaignController extends AbstractRestController
{

    use AuthenticatedUserTrait;

    public function getAction(Request $request)
    {
        $user = $this->getAuthUser($request);

        $data = $this->container->get('adition.campaign_service')->get($user, $request->get('id'));

        return $this->response(compact('data'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postAction(Request $request)
    {
        $user = $this->getAuthUser($request);

        $data = $this->container->get('adition.campaign_service')->create(
            $user, $request->request->all()
        );

        return $this->response(compact('data'), Codes::HTTP_CREATED);
    }

    public function putAction(Request $request)
    {
        $user = $this->getAuthUser($request);

        $data = $this->container->get('adition.campaign_service')->update($user, $request->request->all(),
            $request->get('id'));

        return $this->response(compact('data'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function deleteAction(Request $request)
    {
        $user = $this->getAuthUser($request);
        $this->container->get('adition.campaign_service')->delete($user, $request->get('id'));

        return $this->response(['message' => 'Campaign deleted successfully.']);
    }

}
