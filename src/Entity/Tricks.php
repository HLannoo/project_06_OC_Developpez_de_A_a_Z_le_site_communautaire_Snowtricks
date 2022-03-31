<?php

namespace App\Entity;

use App\Repository\TricksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TricksRepository::class)]
class Tricks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\OneToMany(mappedBy: 'idTrick', targetEntity: Videos::class, orphanRemoval: true)]
    private $idVideos;

    #[ORM\OneToMany(mappedBy: 'idTrick', targetEntity: Images::class, orphanRemoval: true)]
    private $idImages;


    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'tricks')]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    #[ORM\OneToMany(mappedBy: 'trick', targetEntity: Comments::class, orphanRemoval: true)]
    private $comments;

    public function __construct()
    {
        $this->idVideos = new ArrayCollection();
        $this->idImages = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Videos>
     */
    public function getIdVideos(): Collection
    {
        return $this->idVideos;
    }

    public function addIdVideo(Videos $idVideo): self
    {
        if (!$this->idVideos->contains($idVideo)) {
            $this->idVideos[] = $idVideo;
            $idVideo->setIdTrick($this);
        }

        return $this;
    }

    public function removeIdVideo(Videos $idVideo): self
    {
        if ($this->idVideos->removeElement($idVideo)) {
            // set the owning side to null (unless already changed)
            if ($idVideo->getIdTrick() === $this) {
                $idVideo->setIdTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getIdImages(): Collection
    {
        return $this->idImages;
    }

    public function addIdImage(Images $idImage): self
    {
        if (!$this->idImages->contains($idImage)) {
            $this->idImages[] = $idImage;
            $idImage->setIdTrick($this);
        }

        return $this;
    }

    public function removeIdImage(Images $idImage): self
    {
        if ($this->idImages->removeElement($idImage)) {
            // set the owning side to null (unless already changed)
            if ($idImage->getIdTrick() === $this) {
                $idImage->setIdTrick(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
            $this->comments[] = $comment;
            $comment->setTrick($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }
}
