<?php

namespace App\Entity;

use App\Repository\CoinMarketsDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoinMarketsDataRepository::class)
 */
class CoinMarketsData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $coinTicker;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $symbol;

    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    private $string;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $currentPrice;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $marketCap;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $marketCapRank;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $totalVolume;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $dailyLow;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $dailyHigh;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $dailyPriceChange;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $dailyPriceChangePercentage;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $dailyMarketCapChange;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $dailyMarketCapChangePercentage;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $circulatingSupply;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalSupply;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maxSupply;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $jsonData = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoinTicker(): ?string
    {
        return $this->coinTicker;
    }

    public function setCoinTicker(?string $coinTicker): self
    {
        $this->coinTicker = $coinTicker;

        return $this;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(?string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getString(): ?string
    {
        return $this->string;
    }

    public function setString(?string $string): self
    {
        $this->string = $string;

        return $this;
    }

    public function getCurrentPrice(): ?float
    {
        return $this->currentPrice;
    }

    public function setCurrentPrice(?float $currentPrice): self
    {
        $this->currentPrice = $currentPrice;

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

    public function getMarketCapRank(): ?int
    {
        return $this->marketCapRank;
    }

    public function setMarketCapRank(?int $marketCapRank): self
    {
        $this->marketCapRank = $marketCapRank;

        return $this;
    }

    public function getTotalVolume(): ?float
    {
        return $this->totalVolume;
    }

    public function setTotalVolume(?float $totalVolume): self
    {
        $this->totalVolume = $totalVolume;

        return $this;
    }

    public function getDailyLow(): ?float
    {
        return $this->dailyLow;
    }

    public function setDailyLow(?float $dailyLow): self
    {
        $this->dailyLow = $dailyLow;

        return $this;
    }

    public function getDailyHigh(): ?float
    {
        return $this->dailyHigh;
    }

    public function setDailyHigh(?float $dailyHigh): self
    {
        $this->dailyHigh = $dailyHigh;

        return $this;
    }

    public function getDailyPriceChange(): ?float
    {
        return $this->dailyPriceChange;
    }

    public function setDailyPriceChange(?float $dailyPriceChange): self
    {
        $this->dailyPriceChange = $dailyPriceChange;

        return $this;
    }

    public function getDailyPriceChangePercentage(): ?float
    {
        return $this->dailyPriceChangePercentage;
    }

    public function setDailyPriceChangePercentage(?float $dailyPriceChangePercentage): self
    {
        $this->dailyPriceChangePercentage = $dailyPriceChangePercentage;

        return $this;
    }

    public function getDailyMarketCapChange(): ?float
    {
        return $this->dailyMarketCapChange;
    }

    public function setDailyMarketCapChange(?float $dailyMarketCapChange): self
    {
        $this->dailyMarketCapChange = $dailyMarketCapChange;

        return $this;
    }

    public function getDailyMarketCapChangePercentage(): ?float
    {
        return $this->dailyMarketCapChangePercentage;
    }

    public function setDailyMarketCapChangePercentage(?float $dailyMarketCapChangePercentage): self
    {
        $this->dailyMarketCapChangePercentage = $dailyMarketCapChangePercentage;

        return $this;
    }

    public function getCirculatingSupply(): ?int
    {
        return $this->circulatingSupply;
    }

    public function setCirculatingSupply(?int $circulatingSupply): self
    {
        $this->circulatingSupply = $circulatingSupply;

        return $this;
    }

    public function getTotalSupply(): ?int
    {
        return $this->totalSupply;
    }

    public function setTotalSupply(?int $totalSupply): self
    {
        $this->totalSupply = $totalSupply;

        return $this;
    }

    public function getMaxSupply(): ?int
    {
        return $this->maxSupply;
    }

    public function setMaxSupply(?int $maxSupply): self
    {
        $this->maxSupply = $maxSupply;

        return $this;
    }

    public function getJsonData(): ?array
    {
        return $this->jsonData;
    }

    public function setJsonData(?array $jsonData): self
    {
        $this->jsonData = $jsonData;

        return $this;
    }
}
