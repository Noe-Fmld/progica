<?php

namespace App\Entity;

use App\Repository\GiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GiteRepository::class)]
class Gite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\Column(type: 'string', length: 255)]
    private $surface;

    #[ORM\Column(type: 'integer')]
    #[Assert\PositiveOrZero]
    private $nbCouchage;

    #[ORM\Column(type: 'integer')]
    #[Assert\PositiveOrZero]
    private $nbChambre;

    #[ORM\Column(type: 'boolean')]
    private $isAnimalAccepted;

    #[ORM\Column(type: 'float', nullable: true)]
    private $prixAnimal;

    #[ORM\Column(type: 'float')]
    private $prixHauteSaison;

    #[ORM\Column(type: 'float')]
    private $prixBasseSaison;

    #[ORM\OneToMany(mappedBy: 'dateDébut', targetEntity: DispoCalendar::class, orphanRemoval: true)]
    private $debutDispo;

    #[ORM\OneToMany(mappedBy: 'dateFin', targetEntity: DispoCalendar::class, orphanRemoval: true)]
    private $finDispo;

    #[ORM\ManyToOne(targetEntity: Contact::class, inversedBy: 'gite')]
    #[ORM\JoinColumn(nullable: false)]
    private $contact;

    #[ORM\OneToMany(mappedBy: 'gite', targetEntity: OptionPrice::class, orphanRemoval: true)]
    private $optionPrices;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'gites')]
    #[ORM\JoinColumn(nullable: false)]
    private $owner;

    #[ORM\ManyToOne(targetEntity: Cities::class, inversedBy: 'gites')]
    #[ORM\JoinColumn(nullable: false)]
    private $city;

    public function __construct()
    {
        $this->debutDispo = new ArrayCollection();
        $this->finDispo = new ArrayCollection();
        $this->optionPrices = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(string $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getNbCouchage(): ?int
    {
        return $this->nbCouchage;
    }

    public function setNbCouchage(int $nbCouchage): self
    {
        $this->nbCouchage = $nbCouchage;

        return $this;
    }

    public function getNbChambre(): ?int
    {
        return $this->nbChambre;
    }

    public function setNbChambre(int $nbChambre): self
    {
        $this->nbChambre = $nbChambre;

        return $this;
    }

    public function getIsAnimalAccepted(): ?bool
    {
        return $this->isAnimalAccepted;
    }

    public function setIsAnimalAccepted(bool $isAnimalAccepted): self
    {
        $this->isAnimalAccepted = $isAnimalAccepted;

        return $this;
    }

    public function getPrixAnimal(): ?float
    {
        return $this->prixAnimal;
    }

    public function setPrixAnimal(?float $prixAnimal): self
    {
        $this->prixAnimal = $prixAnimal;

        return $this;
    }

    public function getPrixHauteSaison(): ?float
    {
        return $this->prixHauteSaison;
    }

    public function setPrixHauteSaison(float $prixHauteSaison): self
    {
        $this->prixHauteSaison = $prixHauteSaison;

        return $this;
    }

    public function getPrixBasseSaison(): ?float
    {
        return $this->prixBasseSaison;
    }

    public function setPrixBasseSaison(float $prixBasseSaison): self
    {
        $this->prixBasseSaison = $prixBasseSaison;

        return $this;
    }

    /**
     * @return Collection<int, DispoCalendar>
     */
    public function getDebutDispo(): Collection
    {
        return $this->debutDispo;
    }

    public function addDebutDispo(DispoCalendar $debutDispo): self
    {
        if (!$this->debutDispo->contains($debutDispo)) {
            $this->debutDispo[] = $debutDispo;
            $debutDispo->setDateDébut($this);
        }

        return $this;
    }

    public function removeDebutDispo(DispoCalendar $debutDispo): self
    {
        if ($this->debutDispo->removeElement($debutDispo)) {
            // set the owning side to null (unless already changed)
            if ($debutDispo->getDateDébut() === $this) {
                $debutDispo->setDateDébut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DispoCalendar>
     */
    public function getFinDispo(): Collection
    {
        return $this->finDispo;
    }

    public function addFinDispo(DispoCalendar $finDispo): self
    {
        if (!$this->finDispo->contains($finDispo)) {
            $this->finDispo[] = $finDispo;
            $finDispo->setDateFin($this);
        }

        return $this;
    }

    public function removeFinDispo(DispoCalendar $finDispo): self
    {
        if ($this->finDispo->removeElement($finDispo)) {
            // set the owning side to null (unless already changed)
            if ($finDispo->getDateFin() === $this) {
                $finDispo->setDateFin(null);
            }
        }

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

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
            $optionPrice->setGite($this);
        }

        return $this;
    }

    public function removeOptionPrice(OptionPrice $optionPrice): self
    {
        if ($this->optionPrices->removeElement($optionPrice)) {
            // set the owning side to null (unless already changed)
            if ($optionPrice->getGite() === $this) {
                $optionPrice->setGite(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getCity(): ?Cities
    {
        return $this->city;
    }

    public function setCity(?Cities $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }
}
