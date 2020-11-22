<?php


namespace App\Entity;


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
}