<?php

namespace App\Entity;

use App\Repository\ProvinceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProvinceRepository::class)]
class Province
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieu = null;

    #[ORM\ManyToMany(targetEntity: Actualite::class, inversedBy: 'provinces')]
    private Collection $relation;

    /**
     * @var Collection<int, Property>
     */
    #[ORM\ManyToMany(targetEntity: Property::class, mappedBy: 'provinces')]
    private Collection $properties;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * @return Collection<int, Actualite>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(Actualite $relation): static
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
        }

        return $this;
    }

    public function removeRelation(Actualite $relation): static
    {
        $this->relation->removeElement($relation);

        return $this;
    }


    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    // Getter et Setter pour 'properties'
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties[] = $property;
            $property->addProvince($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->properties->removeElement($property)) {
            $property->removeProvince($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->lieu ?? '';
    }
}
