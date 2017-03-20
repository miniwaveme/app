<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Artist;
use AppBundle\Repository\ORM\ArtistRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ArtistTransformer implements DataTransformerInterface
{
    /**
     * @var ArtistRepository
     */
    private $repository;

    /**
     * @param ArtistRepository $repository
     */
    public function __construct(ArtistRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Artist $artist
     * @return string|void
     */
    public function transform($artist)
    {
        if (null === $artist) {
            return;
        }

        return $artist->getName();
    }

    public function reverseTransform($uuid)
    {
        if (!$uuid) {
            return;
        }

        $artist = $this->repository->findOneBy(['uuid' => $uuid]);
        if (null === $artist) {
            throw new TransformationFailedException(sprintf(
                'An artist with this uuid "%s" does not exist!',
                $uuid
            ));
        }

        return $artist;
    }
}