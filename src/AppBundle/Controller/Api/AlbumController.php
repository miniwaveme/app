<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Album;
use AppBundle\Form\Type\Api\AlbumType;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\FileParam;

/**
 * @Route("/albums")
 */
class AlbumController extends Controller
{
    /**
     * @ApiDoc(
     *   section="Album",
     *   resource=true,
     *   description="Gets a album for a given id",
     *   output="AppBundle\Entity\Album",
     *   statusCodes={
     *     200="Returned when successful",
     *     404="Returned when the album is not found",
     *     401="Returned when authentication fails"
     *   }
     * )
     * @Route("/{uuid}", methods={"GET"})
     * @View(serializerGroups={"api"})
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
     *   description="Creates a new album",
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
     * @View(serializerGroups={"api"}, statusCode=201)
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
     *     description="Updates an album",
     *     input={
     *         "class"="AppBundle\Form\Type\Api\AlbumType",
     *         "name"=""
     *     },
     *     output="AppBundle\Entity\Album",
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
     * @param Album $album
     */
    public function deleteAction(Album $album)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($album);
        $em->flush();
    }

    /**
     * @ApiDoc(
     *     section="Album",
     *     resource=false,
     *     description="Attach an album art",
     *     input={
     *         "class"="AppBundle\Form\Type\Api\AlbumType",
     *         "name"=""
     *     },
     *     output="AppBundle\Entity\Album",
     *     statusCodes={
     *         204="Returned when successful",
     *         400="Returned when data is invalid",
     *         401="Returned when authentication fails",
     *         404="Returned when album is not found"
     *     }
     * )
     * @Route("/{uuid}/attach/album-art", methods={"PUT", "PATCH"})
     * @View(serializerGroups={"api"}, statusCode=204)
     * @FileParam(name="image", image=true, default="noImage")
     *
     * @param Request  $request
     * @param Album $album
     *
     * @return JsonResponse
     */
    public function attachAlbumArtAction(Request $request, Album $album)
    {
        return new JsonResponse();
    }
}

