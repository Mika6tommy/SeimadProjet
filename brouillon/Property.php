<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use App\Entity\Traits\Timestampable;
use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
#[ORM\Table(name: "properties")]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['title'])]
class Propertyy
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['property:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Donnez un titre a votre biens")]
    #[Assert\Length(min:4)]
    #[Groups(['property:read'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message:"une brieve description du bien")]
    #[Assert\Length(min:16)]
    #[Groups(['property:read'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Mettez un prix de l'immobilier")]
    #[Groups(['property:read'])]
    private ?int $price = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"La superficie est obligatoire")]
    #[Groups(['property:read'])]
    private ?int $surface = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"le nombre de pieces est obligatoire")]
    #[Groups(['property:read'])]
    private ?int $rooms = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"adresse précise du bien")]
    #[Groups(['property:read'])]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['property:read'])]
    private ?string $postalCode = null;

    #[ORM\Column]
    #[Groups(['property:read'])]
    private ?int $parking = null;

    #[ORM\Column(length: 255)]
    private ?string $Lien = null;

    /**
     * @var Collection<int, Province>
     */
    #[ORM\ManyToMany(targetEntity: Province::class, inversedBy: 'provinces')]
    private Collection $provinces;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug():string
    {
        return (new Slugify())->slugify($this->title);
    }
    
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }
    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): static
    {
        $this->surface = $surface;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): static
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }


    public function getParking(): ?int
    {
        return $this->parking;
    }

    public function setParking(int $parking): static
    {
        $this->parking = $parking;

        return $this;
    }
   
    public function getformatedPrice(): String
    {
        return number_format($this->price,0, '',' ');
    }
    // #[ORM\PrePersist]
    // public function prePersist(): void
    // {
    //     $this->updateTimestamps();
    // }

    // #[ORM\PreUpdate]
    // public function preUpdate(): void
    // {
    //     $this->updateTimestamps();
    // }

    public function getLien(): ?string
    {
        return $this->Lien;
    }

    public function setLien(string $Lien): static
    {
        $this->Lien = $Lien;

        return $this;
    }

    /**
     * @return Collection<int, Province>
     */
    public function getProvince(): Collection
    {
        return $this->provinces;
    }

    public function addProvince(Province $province): static
    {
        if (!$this->provinces->contains($province)) {
            $this->provinces->add($province);
        }

        return $this;
    }

    public function removeProvince(Province $province): static
    {
        $this->provinces->removeElement($province);

        return $this;
    }
    public function __construct()
{
    $this->provinces = new ArrayCollection();
}

}
