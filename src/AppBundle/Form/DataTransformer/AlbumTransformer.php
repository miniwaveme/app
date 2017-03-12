<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Album;
use AppBundle\Repository\ORM\AlbumRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class AlbumTransformer implements DataTransformerInterface
{
    /**
     * @var AlbumRepository
     */
    private $repository;

    /**
     * @param AlbumRepository $repository
     */
    public function __construct(AlbumRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Album $album
     * @return string|void
     */
    public function transform($album)
    {
        if (null === $album) {
            return;
        }

        return $album->getName();
    }

    public function reverseTransform($uuid)
    {
        if (!$uuid) {
            return;
        }

        $album = $this->repository->findOneBy(['uuid' => $uuid]);

        if (null === $album) {
            throw new TransformationFailedException(sprintf(
                'An album with this uuid "%s" does not exist!',
                $uuid
            ));
        }

        return $album;
    }
}