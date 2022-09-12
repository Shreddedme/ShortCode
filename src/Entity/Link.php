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
    private int $id;

    #[ORM\Column(length: 255)]
    private string $originalUrl;

    #[ORM\Column(length: 255)]
    private string $shortCode;

    #[ORM\Column]
    private int $countTransition;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'links')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user;

    public function __construct (string $OriginalURL, string $ShortCode, int $CountTransition, User $user)
    {
        $this->originalUrl = $OriginalURL;
        $this->shortCode = $ShortCode;
        $this->countTransition = $CountTransition;
        $this->user = $user;
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
