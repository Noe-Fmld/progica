<?php

namespace App\Entity;

use App\Repository\DispoCalendarRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DispoCalendarRepository::class)]
class DispoCalendar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Gite::class, inversedBy: 'debutDispo')]
    #[ORM\JoinColumn(nullable: false)]
    private $dateDébut;

    #[ORM\ManyToOne(targetEntity: Gite::class, inversedBy: 'finDispo')]
    #[ORM\JoinColumn(nullable: false)]
    private $dateFin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDébut(): ?Gite
    {
        return $this->dateDébut;
    }

    public function setDateDébut(?Gite $dateDébut): self
    {
        $this->dateDébut = $dateDébut;

        return $this;
    }

    public function getDateFin(): ?Gite
    {
        return $this->dateFin;
    }

    public function setDateFin(?Gite $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }
}
