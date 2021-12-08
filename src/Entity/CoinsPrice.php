<?php

namespace App\Entity;

use App\Repository\CoinsPriceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoinsPriceRepository::class)
 */
class CoinsPrice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ticker;

    /**
     * @ORM\Column(type="json")
     */
    private $vsCurrencies = [];

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $marketCap;

    /**
     * @ORM\Column(type="float")
     */
    private $dayVolume;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $dayChange;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $rawData = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTicker(): ?string
    {
        return $this->ticker;
    }

    public function setTicker(string $ticker): self
    {
        $this->ticker = $ticker;

        return $this;
    }

    public function getVsCurrencies(): ?array
    {
        return $this->vsCurrencies;
    }

    public function setVsCurrencies(array $vsCurrencies): self
    {
        $this->vsCurrencies = $vsCurrencies;

        return $this;
    }

    public function getMarketCap(): ?float
    {
        return $this->marketCap;
    }

    public function setMarketCap(?float $marketCap): self
    {
        $this->marketCap = $marketCap;

        return $this;
    }

    public function getDayVolume(): ?float
    {
        return $this->dayVolume;
    }

    public function setDayVolume(float $dayVolume): self
    {
        $this->dayVolume = $dayVolume;

        return $this;
    }

    public function getDayChange(): ?float
    {
        return $this->dayChange;
    }

    public function setDayChange(?float $dayChange): self
    {
        $this->dayChange = $dayChange;

        return $this;
    }

    public function getRawData(): ?array
    {
        return $this->rawData;
    }

    public function setRawData(?array $rawData): self
    {
        $this->rawData = $rawData;

        return $this;
    }
}
