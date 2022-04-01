<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OptionRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OptionRepository::class)]
#[ORM\Table(name: '`option`')]
class Option
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Choice(['Service', 'Équipement'])]
    private $type;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'optionGite', targetEntity: OptionPrice::class, orphanRemoval: true)]
    private $optionPrices;

    public function __construct()
    {
        $this->optionPrices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, OptionPrice>
     */
    public function getOptionPrices(): Collection
    {
        return $this->optionPrices;
    }

    public function addOptionPrice(OptionPrice $optionPrice): self
    {
        if (!$this->optionPrices->contains($optionPrice)) {
            $this->optionPrices[] = $optionPrice;
            $optionPrice->setOptionGite($this);
        }

        return $this;
    }

    public function removeOptionPrice(OptionPrice $optionPrice): self
    {
        if ($this->optionPrices->removeElement($optionPrice)) {
            // set the owning side to null (unless already changed)
            if ($optionPrice->getOptionGite() === $this) {
                $optionPrice->setOptionGite(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
