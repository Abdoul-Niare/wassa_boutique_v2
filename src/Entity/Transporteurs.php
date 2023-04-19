<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Repository\TransporteursRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransporteursRepository::class)]
class Transporteurs
{
    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameTransport = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?float $priceTransport = null;

    // #[ORM\Column]
    // private ?\DateTimeImmutable $created_at = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameTransport(): ?string
    {
        return $this->nameTransport;
    }

    public function setNameTransport(string $nameTransport): self
    {
        $this->nameTransport = $nameTransport;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPriceTransport(): ?float
    {
        return $this->priceTransport;
    }

    public function setPriceTransport(?float $priceTransport): self
    {
        $this->priceTransport = $priceTransport;

        return $this;
    }

    // public function getCreatedAt(): ?\DateTimeImmutable
    // {
    //     return $this->created_at;
    // }

    // public function setCreatedAt(\DateTimeImmutable $created_at): self
    // {
    //     $this->created_at = $created_at;

    //     return $this;
    // }


    public function __toString()
    {
        $result = $this->nameTransport."[spr]"; //je concatène avec [spr] et je le remplace par <br> dans le twig.
        $result .= $this->description."spr";
        $result .= "Prix: €" .($this->priceTransport/100)."spr";
    
        return $result;
    }
}
