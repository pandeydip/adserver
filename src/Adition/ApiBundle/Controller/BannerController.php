<?php

namespace Adition\ApiBundle\Controller;

use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Adition\CoreBundle\Auth\AuthenticatedUserTrait;

class BannerController extends AbstractRestController
{

    use AuthenticatedUserTrait;

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction(Request $request)
    {
        $user = $this->getAuthUser($request);

        // This will create a banner, and on invalid data it will throw 400 Bad Request exception
        $data = $this->container->get('adition.banner_service')->create($request, $user);

        return $this->response(compact('data'), Codes::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addBannerToCampaignAction(Request $request)
    {
        $user = $this->getAuthUser($request);

        $data = $this->container->get('adition.banner_service')->addBannerToCampaign($request, $user);

        return $this->response(compact('data'));
    }

}
