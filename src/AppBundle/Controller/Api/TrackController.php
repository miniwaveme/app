<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Track;
use AppBundle\Form\Type\Api\TrackType;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TrackController extends Controller
{
    /**
     * @ApiDoc(
     *   section="Track",
     *   resource=true,
     *   description="Gets a event for a given id",
     *   output="AppBundle\Entity\Track",
     *   statusCodes={
     *     200="Returned when successful",
     *     404="Returned when the event is not found",
     *     401="Returned when authentication fails"
     *   }
     * )
     * @Route("/{uuid}", methods={"GET"})
     * @View(serializerGroups={"Default","details"})
     *
     * @param Track $track
     *
     * @return Track
     */
    public function getAction(Track $track)
    {
        return $track;
    }

    /**
     * @ApiDoc(
     *   section="Track",
     *   resource=true,
     *   description="Creates a new event",
     *   input={
     *       "class"="AppBundle\Form\Type\Api\TrackType",
     *       "name"=""
     *   },
     *   output="AppBundle\Entity\Track",
     *   statusCodes={
     *     201="Returned when created",
     *     400="Returned when the form has errors",
     *     401="Returned when authentication fails"
     *   }
     * )
     * @Route("", methods={"POST"})
     * @View(statusCode=201)
     *
     * @param Request $request
     *
     * @return mixed|Track
     */
    public function createAction(Request $request)
    {
        $track = $this->get('app.form.entity_handler')->handle(
            $this->get('app.form_factory')->create(
                new TrackType(),
                new Track()
            ),
            $request
        );

        return $track;
    }
    /**
     * @ApiDoc(
     *     section="Track",
     *     resource=true,
     *     description="Updates a event",
     *     input={
     *         "class"="AppBundle\Form\Type\Api\TrackType",
     *         "name"=""
     *     },
     *     output="AppBundle\Entity\Track",
     *     statusCodes={
     *         204="Returned when successful",
     *         400="Returned when data is invalid",
     *         401="Returned when authentication fails",
     *         404="Returned when event is not found"
     *     }
     * )
     * @Route("/{uuid}", methods={"PUT", "PATCH"})
     * @View(statusCode=204)
     *
     * @param Request  $request
     * @param Track $track
     *
     * @return Track
     */
    public function updateAction(Request $request, Track $track)
    {
        return $this->get('app.form.entity_handler')->handle(
            $this->get('app.form_factory')->create(new TrackType(), $track, [
                'method' => $request->getMethod(),
            ]),
            $request
        );
    }
    /**
     * @ApiDoc(
     *     section="Track",
     *     resource=true,
     *     description="Delete a event",
     *     statusCodes={
     *         204="Returned when successful",
     *         401="Returned when authentication fails",
     *         404="Returned when an event is not found"
     *     }
     * )
     * @Route("/{uuid}", methods={"DELETE"})
     * @View(statusCode=204)
     *
     * @param Track $track
     */
    public function deleteAction(Track $track)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($track);
        $em->flush();
    }
}
