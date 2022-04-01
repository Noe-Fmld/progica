<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 30)]
    private $phone;

    #[ORM\OneToMany(mappedBy: 'contact', targetEntity: Gite::class)]
    private $gite;

    #[ORM\OneToMany(mappedBy: 'contact', targetEntity: DispoContact::class, orphanRemoval: true)]
    private $dispoContacts;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'contacts')]
    #[ORM\JoinColumn(nullable: false)]
    private $giteOwner;

    public function __construct()
    {
        $this->gite = new ArrayCollection();
        $this->dispoContacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Gite>
     */
    public function getGite(): Collection
    {
        return $this->gite;
    }

    public function addGite(Gite $gite): self
    {
        if (!$this->gite->contains($gite)) {
            $this->gite[] = $gite;
            $gite->setContact($this);
        }

        return $this;
    }

    public function removeGite(Gite $gite): self
    {
        if ($this->gite->removeElement($gite)) {
            // set the owning side to null (unless already changed)
            if ($gite->getContact() === $this) {
                $gite->setContact(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DispoContact>
     */
    public function getDispoContacts(): Collection
    {
        return $this->dispoContacts;
    }

    public function addDispoContact(DispoContact $dispoContact): self
    {
        if (!$this->dispoContacts->contains($dispoContact)) {
            $this->dispoContacts[] = $dispoContact;
            $dispoContact->setContact($this);
        }

        return $this;
    }

    public function removeDispoContact(DispoContact $dispoContact): self
    {
        if ($this->dispoContacts->removeElement($dispoContact)) {
            // set the owning side to null (unless already changed)
            if ($dispoContact->getContact() === $this) {
                $dispoContact->setContact(null);
            }
        }

        return $this;
    }

    public function getGiteOwner(): ?User
    {
        return $this->giteOwner;
    }

    public function setGiteOwner(?User $giteOwner): self
    {
        $this->giteOwner = $giteOwner;

        return $this;
    }


    public function __toString()
    {
        return $this->firstName;
    }
}
