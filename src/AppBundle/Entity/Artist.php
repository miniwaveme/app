<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Fresh\VichUploaderSerializationBundle\Annotation as Fresh;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ORM\ArtistRepository")
 * @JMS\ExclusionPolicy("all")
 * @Vich\Uploadable
 * @Fresh\VichSerializableClass
 */
class Artist extends Entity
{
    /**
     * @var string
     * @ORM\Column(type="string")
     *
     * @Assert\NotNull()
     *
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $slug;

    /**
     * @Vich\UploadableField(mapping="artist_image", fileNameProperty="imageName")
     *
     * @JMS\Exclude
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Fresh\VichSerializableField("imageFile")
     * @JMS\Expose()
     * @JMS\SerializedName("image")
     * @JMS\Groups({"api"})
     *
     * @var string
     */
    private $imageName;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @param File $imageFile
     * @return Artist
     */
    public function setImageFile(File $imageFile)
    {
        $this->imageFile = $imageFile;
        if ($imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }


    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Artist
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }
}