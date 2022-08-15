<?php

namespace App\Entity;

use App\Repository\LinkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LinkRepository::class)]
class Link
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $originalUrl = null;

    #[ORM\Column(length: 255)]
    private ?string $shortCode = null;

    #[ORM\Column]
    private ?int $countTransition = null;

    public function __construct (string $OriginalURL, string $ShortCode, int $CountTransition)
    {
        $this->originalUrl = $OriginalURL;
        $this->shortCode = $ShortCode;
        $this->countTransition = $CountTransition;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalUrl(): ?string
    {
        return $this->originalUrl;
    }

    public function setOriginalUrl(string $originalUrl): self
    {
        $this->originalUrl = $originalUrl;

        return $this;
    }

    public function getShortCode(): ?string
    {
        return $this->shortCode;
    }

    public function setShortCode(string $shortCode): self
    {
        $this->shortCode = $shortCode;

        return $this;
    }

    public function getCountTransition(): ?int
    {
        return $this->countTransition;
    }

    public function setCountTransition(int $countTransition): self
    {
        $this->countTransition = $countTransition;

        return $this;
    }
}
