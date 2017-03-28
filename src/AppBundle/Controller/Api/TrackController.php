<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Track;
use AppBundle\Form\Type\Api\TrackType;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\FileParam;

class TrackController extends Controller
{
    /**
     * @ApiDoc(
     *   section="Track",
     *   resource=true,
     *   description="Gets an album for a given id",
     *   output="AppBundle\Entity\Track",
     *   statusCodes={
     *     200="Returned when successful",
     *     404="Returned when the album is not found",
     *     401="Returned when authentication fails"
     *   }
     * )
     * @Route("/{uuid}", methods={"GET"})
     * @View(serializerGroups={"api"})
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
     *   description="Creates a new album",
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
     * @View(serializerGroups={"api"}, statusCode=201)
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
     *     description="Updates an album",
     *     input={
     *         "class"="AppBundle\Form\Type\Api\TrackType",
     *         "name"=""
     *     },
     *     output="AppBundle\Entity\Track",
     *     statusCodes={
     *         204="Returned when successful",
     *         400="Returned when data is invalid",
     *         401="Returned when authentication fails",
     *         404="Returned when album is not found"
     *     }
     * )
     * @Route("/{uuid}", methods={"PUT", "PATCH"})
     * @View(serializerGroups={"api"}, statusCode=204)
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
     *     description="Delete an album",
     *     statusCodes={
     *         204="Returned when successful",
     *         401="Returned when authentication fails",
     *         404="Returned when an album is not found"
     *     }
     * )
     * @Route("/{uuid}", methods={"DELETE"})
     * @View(serializerGroups={"api"}, statusCode=204)
     *
     * @param Track $track
     */
    public function deleteAction(Track $track)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($track);
        $em->flush();
    }

    /**
     * @ApiDoc(
     *     section="Track",
     *     resource=false,
     *     description="Attach a track",
     *     input={
     *         "class"="AppBundle\Form\Type\Api\TrackType",
     *         "name"=""
     *     },
     *     output="AppBundle\Entity\Track",
     *     statusCodes={
     *         204="Returned when successful",
     *         400="Returned when data is invalid",
     *         401="Returned when authentication fails",
     *         404="Returned when track is not found"
     *     }
     * )
     * @FileParam(name="audioFile", requirements={"mimeTypes"="audio/ogg", "maxSize"="20000k"}, strict=true, nullable=false)
     * @Route("/{uuid}/attach/audio-file", methods={"POST"})
     * @View(serializerGroups={"api"}, statusCode=204)
     *
     * @param ParamFetcher $paramFetcher
     * @param Track $track
     *
     * @return Track
     */
    public function attachAudioFileAction(ParamFetcher $paramFetcher, Track $track)
    {
        $track->setAudioFile($paramFetcher->get('audioFile'));
        $this->get('app.repository.track')->update($track);

        return $track;
    }
}
