<?php

namespace App\Entity;

use AllowDynamicProperties;
use App\Form\QuackType;
use App\Repository\QuackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

#[AllowDynamicProperties] #[ORM\Entity(repositoryClass: QuackRepository::class)]
class Quack
{
    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->duckscreen = 'default';
        $this->ducktag = '#default';
        $this->comments = new ArrayCollection();


    }


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at;

    #[ORM\Column(type: Types::STRING)]
    private ?string $username;

    #[ORM\Column(type: Types::STRING)]
    private ?string $duckscreen;

    #[ORM\Column(type: Types::TEXT)]
    private?string $ducktag = null;

    /**
     * @var Collection<int, Comments>
     */
    #[ORM\OneToMany(targetEntity: Comments::class, mappedBy: 'quack')]
    private Collection $comments;



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

    public function getParent()
    {

        return new QuackType();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quack::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {

    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {

    }

    public function getBlockPrefix(): string
    {
        return 'app_quack';
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setMessages($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMessages() === $this) {
                $comment->setMessages(null);
            }
        }

        return $this;
    }
}
