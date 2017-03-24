<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ORM\AlbumRepository")
 * @JMS\ExclusionPolicy("all")
 * @Vich\Uploadable
 */
class Album extends Entity
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
     * @var int
     * @ORM\Column(type="integer", length=4)
     *
     * @Assert\GreaterThan(1900)
     *
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $year;

    /**
     *
     * @Vich\UploadableField(mapping="album_art_image", fileNameProperty="imageName")
     *
     * @var File
     */
    private $albumArtFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $albumArtName;

    /**
     * @var Artist
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Artist")
     *
     * @Assert\Valid
     *
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $artist;

    /**
     * @var Track[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Track", mappedBy="album")
     *
     * @Assert\Valid
     *
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $tracks;

    public function __construct()
    {
        parent::__construct();
        $this->tracks = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return File
     */
    public function getAlbumArtFile()
    {
        return $this->albumArtFile;
    }

    /**
     * @param File $albumArtFile
     * @return Album
     */
    public function setAlbumArtFile(File $albumArtFile)
    {
        $this->albumArtFile = $albumArtFile;
        if ($albumArtFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getAlbumArtName()
    {
        return $this->albumArtName;
    }

    /**
     * @param string $albumArtName
     * @return Album
     */
    public function setAlbumArtName($albumArtName)
    {
        $this->albumArtName = $albumArtName;
        return $this;
    }

    /**
     * @return Artist
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param Artist $artist
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

    /**
     * @return Track[]|ArrayCollection
     */
    public function getTracks()
    {
        return $this->tracks;
    }
}