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
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
#[ORM\Entity(repositoryClass: ActualiteRepository::class)]
#[Vich\Uploadable]
class Actualite extends ServiceEntityRepository
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

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'Lien')]
    private ?File $LienImage = null;

    #[ORM\OneToMany(targetEntity: ActualiteImage::class, mappedBy: 'actualite', cascade: ['persist', 'remove'])]
    private Collection $galerie;

    public function __construct()
    {
        $this->galerie = new ArrayCollection();
        $this->provinces = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }
   
    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->title);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): self
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
    
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getFormattedCreatedAt(): string
    {
        if (!$this->createdAt) {
            return '';
        }

        $formatter = new \IntlDateFormatter(
            'fr_FR',
            \IntlDateFormatter::LONG,
            \IntlDateFormatter::SHORT,
            'Indian/Antananarivo',
            \IntlDateFormatter::GREGORIAN
        );

        return $formatter->format($this->createdAt);
    }

    public function getLien(): ?string
    {
        return $this->Lien;
    }

    public function setLien(?string $Lien): self
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
        if (null !== $LienImage) {
            $this->updatedAt = new \DateTimeImmutable();
        }
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

    /**
     * @return Collection<int, ActualiteImage>
     */
    public function getGalerie(): Collection
    {
        return $this->galerie;
    }

    public function addGalerie(ActualiteImage $actualiteImage): self
    {
        if (!$this->galerie->contains($actualiteImage)) {
            $this->galerie[] = $actualiteImage;
            $actualiteImage->setActualite($this);
        }

        return $this;
    }

    public function removeGalerie(ActualiteImage $actualiteImage): self
    {
        if ($this->galerie->removeElement($actualiteImage)) {
            // set the owning side to null (unless already changed)
            if ($actualiteImage->getActualite() === $this) {
                $actualiteImage->setActualite(null);
            }
        }

        return $this;
    }
}