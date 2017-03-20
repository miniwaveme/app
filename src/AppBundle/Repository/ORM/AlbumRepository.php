<?php

namespace AppBundle\Repository\ORM;

use AppBundle\Entity\Album;
use Doctrine\ORM\EntityRepository;

class AlbumRepository extends EntityRepository
{
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