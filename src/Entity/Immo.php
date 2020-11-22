<?php

namespace App\Entity;

use App\Repository\ImmoRepository;
use Cocur\Slugify\Slugify;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Constraints;

/**
 * @ORM\Entity(repositoryClass=ImmoRepository::class)
 */
class Immo
{
    const HEAT = [
        0 => "Électrique",
        1 => "Gaz"
    ] ;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Constraints\NotBlank(message="Le titre est obligatoire.")
     *
     * @ORM\Column(type="string", length=127, nullable=false)
     * @var string
     */
    private $title;

    /**
     * @Constraints\Range(min=1, minMessage="Le bien doit avoir au moins, une pièce.")
     *
     * @ORM\Column(type="integer")
     */
    private $rooms;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $bedrooms;

    /**
     * @Constraints\Range(min=10, minMessage="Le bien doit avoir au moins 10 m2 de surface.")
     *
     * @ORM\Column(type="integer")
     */
    private $surface;

    /**
     * @Constraints\Range(min=1, minMessage="Le rez de chaussée au moins.")
     *
     * @ORM\Column(type="integer")
     */
    private $floor;

    /**
     * @Constraints\Range(min=1, minMessage="Le bien ne peut pas être gratuit.")
     *
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @Constraints\Choice(choices={"Électrique", "Gaz"})
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $heat;

    /**
     * @Constraints\NotNull
     *
     * @ORM\Column(type="string", length=127)
     */
    private $city;

    /**
     * @Constraints\NotNull
     *
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @Constraints\NotNull
     *
     * @ORM\Column(type="string", length=255)
     */
    private $postalCode;

    /**
     * @Constraints\NotNull
     *
     * @ORM\Column(type="boolean", options={"default":true})
     */
    private $sold;

    /**
     * @Constraints\NotNull
     *
     * @ORM\Column(type="datetime")
     */
    private $addedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Option::class, mappedBy="properties")
     */
    private $options;

    public function __construct()
    {
        $this->addedAt = new DateTime() ;
        $this->sold = false ;
        $this->options = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getHeat(): ?int
    {
        return $this->heat;
    }

    public function getHeatType(): string
    {
        return self::HEAT[$this->heat];
    }

    public function setHeat(int $heat): self
    {
        $this->heat = $heat;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getAddedAt(): ?\DateTimeInterface
    {
        return $this->addedAt;
    }

    public function setAddedAt(\DateTimeInterface $addedAt): self
    {
        $this->addedAt = $addedAt;

        return $this;
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

    public function getSluggedTitle() : string {
        return (new Slugify())->slugify($this->title, '_') ;
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->addProperty($this);
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        if ($this->options->removeElement($option)) {
            $option->removeProperty($this);
        }

        return $this;
    }
}
