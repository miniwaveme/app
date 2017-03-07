<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Album;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/albums")
 */
class AlbumController extends Controller
{
    /**
     * @ApiDoc(
     *   section="Album",
     *   resource=true,
     *   description="Gets a event for a given id",
     *   output="AppBundle\Entity\Album",
     *   statusCodes={
     *     200="Returned when successful",
     *     404="Returned when the event is not found",
     *     401="Returned when authentication fails"
     *   }
     * )
     * @Route("/{uuid}", methods={"GET"})
     * @View(serializerGroups={"Default","details"})
     *
     * @param Album $album
     *
     * @return Album
     */
    public function getAction(Album $album)
    {
        return $album;
    }
    /**
     * @ApiDoc(
     *   section="Album",
     *   resource=true,
     *   description="Creates a new event",
     *   input={
     *       "class"="AppBundle\Form\Type\Api\AlbumType",
     *       "name"=""
     *   },
     *   output="AppBundle\Entity\Album",
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
     * @return mixed|Album
     */
    public function createAction(Request $request)
    {
        $album = $this->get('app.form.entity_handler')->handle(
            $this->get('app.form_factory')->create(
                new AlbumType(),
                new Album()
            ),
            $request
        );

        return $album;
    }
    /**
     * @ApiDoc(
     *     section="Album",
     *     resource=true,
     *     description="Updates a event",
     *     input={
     *         "class"="AppBundle\Form\Type\Api\AlbumType",
     *         "name"=""
     *     },
     *     output="AppBundle\Entity\Album",
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
     * @param Album $album
     *
     * @return Album
     */
    public function updateAction(Request $request, Album $album)
    {
        return $this->get('app.form.entity_handler')->handle(
            $this->get('app.form_factory')->create(new AlbumType(), $album, [
                'method' => $request->getMethod(),
            ]),
            $request
        );
    }
    /**
     * @ApiDoc(
     *     section="Album",
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
     * @param Album $album
     */
    public function deleteAction(Album $album)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($album);
        $em->flush();
    }
}
}
