<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $path;

    #[ORM\ManyToOne(targetEntity: Tricks::class, inversedBy: 'idImages')]
    #[ORM\JoinColumn(nullable: false)]
    private $idTrick;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getIdTrick(): ?Tricks
    {
        return $this->idTrick;
    }

    public function setIdTrick(?Tricks $idTrick): self
    {
        $this->idTrick = $idTrick;

        return $this;
    }
}