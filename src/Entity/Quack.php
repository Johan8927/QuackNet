<?php

namespace App\Entity;

use App\Repository\QuackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuackRepository::class)]
class Quack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $duckscreen = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ducktag = null;

    #[ORM\ManyToOne(targetEntity: UserSecurity::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserSecurity $author = null;

    #[ORM\OneToMany(targetEntity: Comments::class, mappedBy: 'quack', cascade: ['persist', 'remove'])]
    private Collection $comments;

    #[ORM\Column(type: Types::STRING)]
    private ?string $username = null;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->comments = new ArrayCollection();
        $this->duckscreen = 'default';
        $this->ducktag = '#default';
        $this->author = new UserSecurity();

    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    // Getters et setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDuckscreen(): ?string
    {
        return $this->duckscreen;
    }

    public function setDuckscreen(?string $duckscreen): self
    {
        $this->duckscreen = $duckscreen;

        return $this;
    }

    public function getDucktag(): ?string
    {
        return $this->ducktag;
    }

    public function setDucktag(?string $ducktag): self
    {
        $this->ducktag = $ducktag;

        return $this;
    }

    public function getAuthor(): ?UserSecurity
    {
        return $this->author;
    }

    public function setAuthor(?UserSecurity $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setQuack($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // Supprimez la relation côté `Comments` si nécessaire
            if ($comment->getQuack() === $this) {
                $comment->setQuack(null);
            }
        }

        return $this;
    }
}
