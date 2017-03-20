<?php

namespace AppBundle\Repository\ORM;

use AppBundle\Entity\Track;
use Doctrine\ORM\EntityRepository;

class TrackRepository extends EntityRepository
{
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