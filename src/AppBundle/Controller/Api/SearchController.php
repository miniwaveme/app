<?php

namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/search")
 */
class SearchController extends Controller
{
    /**
     * @ApiDoc(
     *   section="Search",
     *   resource=true,
     *   description="Return results for a search",
     *   statusCodes={
     *     200="Returned when successful"
     *   }
     * )
     * @Route("", methods={"GET"})
     * @View(serializerGroups={"api"})
     *
     * @return JsonResponse
     */
    public function getAction(ParamFetcher $paramFetcher)
    {
        $result = [];
        return $result;
    }
}