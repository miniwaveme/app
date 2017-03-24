<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\MappedSuperclass()
 * @JMS\ExclusionPolicy("all")
 */
class Entity
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=36)
     *
     * @JMS\Type("string")
     * @JMS\Expose
     * @JMS\Groups({"api"})

     */
    protected $uuid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     *
     * @JMS\Expose
     * @JMS\Groups({"api"})
     *
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     *
     * @JMS\Expose
     * @JMS\Groups({"api"})
     *
     * @Gedmo\Timestampable(on="create")
     */
    protected  $createdAt;

    public function __construct()
    {
        $this->uuid = \Ramsey\Uuid\Uuid::uuid4();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}