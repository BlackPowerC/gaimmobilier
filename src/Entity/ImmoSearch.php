<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class ImmoSearch
{
    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     */
    private $minSurface;

    /**
     * @var ArrayCollection|null
     */
    private $options;

    public function __construct() {
        $this->options = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int {
        return $this->maxPrice;
    }

    /**
     * @param int|null $maxPrice
     * @return ImmoSearch
     */
    public function setMaxPrice(?int $maxPrice): ImmoSearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinSurface(): ?int {
        return $this->minSurface;
    }

    /**
     * @param int|null $minSurface
     * @return ImmoSearch
     */
    public function setMinSurface(?int $minSurface): ImmoSearch
    {
        $this->minSurface = $minSurface;
        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getOptions(): ?ArrayCollection
    {
        return $this->options;
    }

    /**
     * @param ArrayCollection|null $options
     * @return ImmoSearch
     */
    public function setOptions(?ArrayCollection $options): ImmoSearch
    {
        $this->options = $options;
        return $this;
    }
}