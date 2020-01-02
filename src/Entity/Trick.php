<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickRepository")
 *  * @UniqueEntity(fields={"name"}, message="Une figure avec le même nom existe déjà")
 */
class Trick
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $figureGroup;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="trick", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tricks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TrickPic", mappedBy="trick", orphanRemoval=true)
     */
    private $trickPics;

    /**
     * @ORM\Column(type="text")
     */
    private $trickVideos;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->trickPics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFigureGroup(): ?string
    {
        return $this->figureGroup;
    }

    public function setFigureGroup(?string $figureGroup): self
    {
        $this->figureGroup = $figureGroup;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTrick($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|TrickPic[]
     */
    public function getTrickPics(): Collection
    {
        return $this->trickPics;
    }

    public function addTrickPic(TrickPic $trickPic): self
    {
        if (!$this->trickPics->contains($trickPic)) {
            $this->trickPics[] = $trickPic;
            $trickPic->setTrick($this);
        }

        return $this;
    }

    public function removeTrickPic(TrickPic $trickPic): self
    {
        if ($this->trickPics->contains($trickPic)) {
            $this->trickPics->removeElement($trickPic);
            // set the owning side to null (unless already changed)
            if ($trickPic->getTrick() === $this) {
                $trickPic->setTrick(null);
            }
        }

        return $this;
    }

    /**
     *
     */
    public function getTrickVideos(): array
    {
        return explode("\n", $this->trickVideos);
    }

    public function setTrickVideos(array $videos): self
    {
        $this->trickVideos = implode("\n", $videos);

        return $this;
    }

}
