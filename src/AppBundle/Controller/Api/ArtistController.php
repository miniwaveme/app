<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Artist;
use AppBundle\Form\Type\Api\ArtistType;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\FileParam;

/**
 * @Route("/artists")
 */
class ArtistController extends Controller
{
    /**
     * @ApiDoc(
     *   section="Artist",
     *   resource=true,
     *   description="Gets an album for a given id",
     *   output="AppBundle\Entity\Artist",
     *   statusCodes={
     *     200="Returned when successful",
     *     404="Returned when the album is not found",
     *     401="Returned when authentication fails"
     *   }
     * )
     * @Route("/{uuid}", methods={"GET"})
     * @View(serializerGroups={"api"})
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
     *   description="Creates a new album",
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
     * @View(serializerGroups={"api"}, statusCode=201)
     *
     * @param Request $request
     *
     * @return mixed|Artist
     */
    public function createAction(Request $request)
    {
        return $this->get('app.form.entity_handler')->handle(
            $this->get('app.form_factory')->create(ArtistType::class, new Artist(), [
                'method' => $request->getMethod(),
            ]),
            $request
        );
    }

    /**
     * @ApiDoc(
     *     section="Artist",
     *     resource=true,
     *     description="Updates an album",
     *     input={
     *         "class"="AppBundle\Form\Type\Api\ArtistType",
     *         "name"=""
     *     },
     *     output="AppBundle\Entity\Artist",
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
     * @param Artist $artist
     *
     * @return Artist
     */
    public function updateAction(Request $request, Artist $artist)
    {
        return $this->get('app.form.entity_handler')->handle(
            $this->get('app.form_factory')->create(ArtistType::class, $artist, [
                'method' => $request->getMethod(),
            ]),
            $request
        );
    }
    /**
     * @ApiDoc(
     *     section="Artist",
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
     * @param Artist $artist
     */
    public function deleteAction(Artist $artist)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($artist);
        $em->flush();
    }

    /**
     * @ApiDoc(
     *     section="Artist",
     *     resource=false,
     *     description="Attach an image",
     *     input={
     *         "class"="AppBundle\Form\Type\Api\ArtistType",
     *         "name"=""
     *     },
     *     output="AppBundle\Entity\Artist",
     *     statusCodes={
     *         204="Returned when successful",
     *         400="Returned when data is invalid",
     *         401="Returned when authentication fails",
     *         404="Returned when artist is not found"
     *     }
     * )
     * @FileParam(name="image", image=true, strict=true, nullable=false)
     * @Route("/{uuid}/attach/image", methods={"POST"})
     * @View(serializerGroups={"api"}, statusCode=204)
     *
     * @param ParamFetcher $paramFetcher
     * @param Artist $artist
     *
     * @return Artist
     */
    public function attachArtistArtAction(ParamFetcher $paramFetcher, Artist $artist)
    {
        $artist->setImageFile($paramFetcher->get('image'));
        $this->get('app.repository.artist')->update($artist);

        return $artist;
    }
}
