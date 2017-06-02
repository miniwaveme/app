<?php

namespace AppBundle\Repository\ORM;

use AppBundle\Entity\Album;
use Doctrine\ORM\EntityRepository;

class AlbumRepository extends EntityRepository
{
    /**
     * @param string $slug
     * @param string $artistSlug
     * @return Album
     */
    public function findAlbumBySlug($slug, $artistSlug)
    {
        return $this->createQueryBuilder('a')
            ->join('t.artist', 'artist')
            ->where('slug = %slug%')
            ->andWhere('artist.slug = %artist_slug%')
            ->setParameter('artist_slug', $artistSlug)
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @param Album $album
     * @return Album
     */
    public function update(Album $album)
    {
        $this->_em->persist($album);
        $this->_em->flush();

        return $album;
    }
}