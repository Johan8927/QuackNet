<?php

namespace App\Entity;

use AllowDynamicProperties;
use App\Repository\QuackRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[AllowDynamicProperties] #[ORM\Entity(repositoryClass: QuackRepository::class)]
class Quack
{
    public function __construct()
    {
        $this->created_at = new \DateTime();
    }


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $username = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $duckscreen = null;

    #[ORM\Column(type: Types::TEXT)]
    private?string $ducktag = null;



    public function getDuckscreen(): ?string
    {
        return $this->duckscreen;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getDuckname(): ?string
    {
        return $this->duckname;
    }

    public function setDuckname(?string $duckname): void
    {
        $this->duckname = $duckname;
    }
    public function setDuckscreen(?string $duckscreen): void
    {
        $this->duckscreen = $duckscreen;
    }

    public function getDucktag(): ?string
    {
        return $this->ducktag;
    }

    public function setDucktag(?string $ducktag): void
    {
        $this->ducktag = $ducktag;
    }

}
