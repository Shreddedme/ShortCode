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
    private ?string $OriginalURL = null;

    #[ORM\Column(length: 255)]
    private ?string $ShortCode = null;

    #[ORM\Column]
    private ?int $CountTransition = null;

    public function __construct (string $OriginalURL, string $ShortCode, int $CountTransition)
    {
        $this->OriginalURL = $OriginalURL;
        $this->ShortCode = $ShortCode;
        $this->CountTransition = $CountTransition;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalURL(): ?string
    {
        return $this->OriginalURL;
    }

    public function setOriginalURL(string $OriginalURL): self
    {
        $this->OriginalURL = $OriginalURL;

        return $this;
    }

    public function getShortCode(): ?string
    {
        return $this->ShortCode;
    }

    public function setShortCode(string $ShortCode): self
    {
        $this->ShortCode = $ShortCode;

        return $this;
    }

    public function getCountTransition(): ?int
    {
        return $this->CountTransition;
    }

    public function setCountTransition(int $CountTransition): self
    {
        $this->CountTransition = $CountTransition;

        return $this;
    }
}
