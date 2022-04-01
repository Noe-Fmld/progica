<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;



#[ORM\Index(name:"departments_code_index", columns:["code"])]
#[ORM\Index(name:"departments_region_code_foreign", columns:["region_code"])]
#[ORM\Entity(repositoryClass:"App\Repository\DepartmentsRepository")]
class Departments
{
    
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 3)]
    private $code;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\ManyToOne(targetEntity: Regions::class)]
    #[ORM\JoinColumn(name:"region_code", referencedColumnName:"code")]
    private $regionCode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getRegionCode(): ?Regions
    {
        return $this->regionCode;
    }

    public function setRegionCode(?Regions $regionCode): self
    {
        $this->regionCode = $regionCode;

        return $this;
    }


}
