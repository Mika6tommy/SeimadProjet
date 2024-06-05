<?php

namespace App\Entity;

use DateTimeImmutable;
use Cocur\Slugify\Slugify;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ActualiteRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: ActualiteRepository::class)]
#[Vich\Uploadable]
class Actualite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieu = null;

    #[ORM\ManyToMany(targetEntity: Province::class, mappedBy: 'relation')]
    private Collection $provinces;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Lien = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Vich\UploadableField(mapping:'products', fileNameProperty:'Lien' )]
    private ?File $LienImage = null;

    public function getSlug():string
    {
        return (new Slugify())->slugify($this->title);
    }

    public function __construct()
    {
        $this->provinces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
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
     * @return Collection<int, Province>
     */
    public function getProvinces(): Collection
    {
        return $this->provinces;
    }

    public function addProvince(Province $province): static
    {
        if (!$this->provinces->contains($province)) {
            $this->provinces->add($province);
            $province->addRelation($this);
        }

        return $this;
    }

    public function removeProvince(Province $province): static
    {
        if ($this->provinces->removeElement($province)) {
            $province->removeRelation($this);
        }

        return $this;
    }

    public function updateTimeStamp(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
    public function getLien(): ?string
    {
        return $this->Lien;
    }

    public function setLien(?string $Lien): static
    {
        $this->Lien = $Lien;

        return $this;
    }

    public function getLienImage(): ?File
    {
        return $this->LienImage;
    }

    public function setLienImage(?File $LienImage): void
    {
        $this->LienImage = $LienImage;
        if(null !== $LienImage){
        }
        $this->updatedAt = new \DateTimeImmutable();
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
}
