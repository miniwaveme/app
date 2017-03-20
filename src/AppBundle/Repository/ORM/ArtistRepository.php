<?php

namespace AppBundle\Repository\ORM;

use AppBundle\Entity\Artist;
use Doctrine\ORM\EntityRepository;

class ArtistRepository extends EntityRepository
{
    /**
     * @param Artist $artist
     * @return Artist
     */
    public function update(Artist $artist)
    {
        $this->_em->persist($artist);
        $this->_em->flush();

        return $artist;
    }
}