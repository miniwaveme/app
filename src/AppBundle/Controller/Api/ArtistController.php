<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Artist;
use AppBundle\Form\Type\Api\ArtistType;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/artists")
 */
class ArtistController extends Controller
{
    /**
     * @ApiDoc(
     *   section="Artist",
     *   resource=true,
     *   description="Gets a event for a given id",
     *   output="AppBundle\Entity\Artist",
     *   statusCodes={
     *     200="Returned when successful",
     *     404="Returned when the event is not found",
     *     401="Returned when authentication fails"
     *   }
     * )
     * @Route("/{uuid}", methods={"GET"})
     * @View(serializerGroups={"Default","details"})
     *
     * @param Artist $artist
     *
     * @return Artist
     */
    public function getAction(Artist $artist)
    {
        return $artist;
    }
    /**
     * @ApiDoc(
     *   section="Artist",
     *   resource=true,
     *   description="Creates a new event",
     *   input={
     *       "class"="AppBundle\Form\Type\Api\ArtistType",
     *       "name"=""
     *   },
     *   output="AppBundle\Entity\Artist",
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
     * @return mixed|Artist
     */
    public function createAction(Request $request)
    {
        $artist = $this->get('app.form.entity_handler')->handle(
            $this->get('app.form_factory')->create(
                new ArtistType(),
                new Artist()
            ),
            $request
        );

        return $artist;
    }
    /**
     * @ApiDoc(
     *     section="Artist",
     *     resource=true,
     *     description="Updates a event",
     *     input={
     *         "class"="AppBundle\Form\Type\Api\ArtistType",
     *         "name"=""
     *     },
     *     output="AppBundle\Entity\Artist",
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
     * @param Artist $artist
     *
     * @return Artist
     */
    public function updateAction(Request $request, Artist $artist)
    {
        return $this->get('app.form.entity_handler')->handle(
            $this->get('app.form_factory')->create(new ArtistType(), $artist, [
                'method' => $request->getMethod(),
            ]),
            $request
        );
    }
    /**
     * @ApiDoc(
     *     section="Artist",
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
     * @param Artist $artist
     */
    public function deleteAction(Artist $artist)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($artist);
        $em->flush();
    }
}
