<?php

namespace AppBundle\Repository\ORM;

use AppBundle\Entity\Track;
use Doctrine\ORM\EntityRepository;

class TrackRepository extends EntityRepository
{
    /**
     * @param string $slug
     * @param string $artistSlug
     * @param string $albumSlug
     * @return Track
     */
    public function findTrackBySlug($slug, $artistSlug, $albumSlug)
    {
        return $this->createQueryBuilder('t')
            ->join('t.artist', 'artist')
            ->join('t.album', 'album')
            ->where('slug = %slug%')
            ->andWhere('album.slug = %album_slug%')
            ->andWhere('artist.slug = %artist_slug%')
            ->setParameter('album_slug', $albumSlug)
            ->setParameter('artist_slug', $artistSlug)
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @param Track $track
     * @return Track
     */
    public function update(Track $track)
    {
        $this->_em->persist($track);
        $this->_em->flush();

        return $track;
    }
}