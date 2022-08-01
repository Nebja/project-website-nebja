<?php

namespace App\Entity;

use App\Repository\VideosRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VideosRepository::class)
 */
class Videos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $file;

    /**
     * @ORM\Column(type="integer")
     */
    private $madeAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgPoster;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subsFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $YoutubeTrailer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $videoType;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $entryAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getMadeAt(): ?int
    {
        return $this->madeAt;
    }

    public function setMadeAt(int $madeAt): self
    {
        $this->madeAt = $madeAt;

        return $this;
    }

    public function getImgPoster(): ?string
    {
        return $this->imgPoster;
    }

    public function setImgPoster(string $imgPoster): self
    {
        $this->imgPoster = $imgPoster;

        return $this;
    }

    public function getSubsFile(): ?string
    {
        return $this->subsFile;
    }

    public function setSubsFile(string $subsFile): self
    {
        $this->subsFile = $subsFile;

        return $this;
    }

    public function getYoutubeTrailer(): ?string
    {
        return $this->YoutubeTrailer;
    }

    public function setYoutubeTrailer(string $YoutubeTrailer): self
    {
        $this->YoutubeTrailer = $YoutubeTrailer;

        return $this;
    }

    public function getVideoType(): ?string
    {
        return $this->videoType;
    }

    public function setVideoType(string $videoType): self
    {
        $this->videoType = $videoType;

        return $this;
    }

    public function getEntryAt(): ?DateTimeImmutable
    {
        return $this->entryAt;
    }

    public function setEntryAt(DateTimeImmutable $entryAt): self
    {
        $this->entryAt = $entryAt;

        return $this;
    }
}
