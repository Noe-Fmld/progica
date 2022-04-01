<?php

namespace App\Entity;

use App\Repository\OptionPriceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionPriceRepository::class)]
class OptionPrice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Gite::class, inversedBy: 'optionPrices')]
    #[ORM\JoinColumn(nullable: false)]
    private $gite;

    #[ORM\ManyToOne(targetEntity: Option::class, inversedBy: 'optionPrices')]
    #[ORM\JoinColumn(nullable: false)]
    private $optionGite;

    #[ORM\Column(type: 'float')]
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGite(): ?Gite
    {
        return $this->gite;
    }

    public function setGite(?Gite $gite): self
    {
        $this->gite = $gite;

        return $this;
    }

    public function getOptionGite(): ?Option
    {
        return $this->optionGite;
    }

    public function setOptionGite(?Option $optionGite): self
    {
        $this->optionGite = $optionGite;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
