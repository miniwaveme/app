<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ORM\TrackRepository")
 * @JMS\ExclusionPolicy("all")
 * @Vich\Uploadable
 */
class Track extends Entity
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     *
     * @Assert\NotNull()
     *
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $number;

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
     * @ORM\Column(type="integer")
     *
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $duration;

    /**
     * @var int
     * @ORM\Column(type="integer")
     *
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $bpm;

    /**
     *
     * @Vich\UploadableField(mapping="audio_file", fileNameProperty="audioFileName")
     *
     * @var File
     */
    private $audioFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $audioFileName;

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
     * @var Album
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Album", inversedBy="tracks")
     *
     * @Assert\Valid
     *
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $album;

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param $number
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param $duration
     * @return $this
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return int
     */
    public function getBpm()
    {
        return $this->bpm;
    }

    /**
     * @param int $bpm
     * @return $this
     */
    public function setBpm($bpm)
    {
        $this->bpm = $bpm;
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
     * @return $this
     */
    public function setArtist(Artist $artist)
    {
        $this->artist = $artist;
        return $this;
    }

    /**
     * @return Album
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @param Album $album
     * @return $this
     */
    public function setAlbum(Album $album)
    {
        $this->album = $album;
        return $this;
    }

    /**
     * @return File
     */
    public function getAudioFile()
    {
        return $this->audioFile;
    }

    /**
     * @param File $audioFile
     * @return Track
     */
    public function setAudioFile(File $audioFile)
    {
        $this->audioFile = $audioFile;
        if ($audioFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getAudioFileName()
    {
        return $this->audioFileName;
    }

    /**
     * @param string $audioFileName
     * @return Track
     */
    public function setAudioFileName($audioFileName)
    {
        $this->audioFileName = $audioFileName;
        return $this;
    }
}