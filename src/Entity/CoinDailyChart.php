<?php

namespace App\Entity;

use App\Repository\CoinDailyChartRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoinDailyChartRepository::class)
 */
class CoinDailyChart
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
    private $vsCurrency;

    /**
     * @ORM\Column(type="text", nullable=true)
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

    public function setCoinTicker(string $coinTicker): self
    {
        $this->coinTicker = $coinTicker;

        return $this;
    }

    public function getVsCurrency(): ?string
    {
        return $this->vsCurrency;
    }

    public function setVsCurrency(string $vsCurrency): self
    {
        $this->vsCurrency = $vsCurrency;

        return $this;
    }

    public function getJsonData(): ?string
    {
        return $this->jsonData;
    }

    public function setJsonData(?string $jsonData): self
    {
        $this->jsonData = $jsonData;

        return $this;
    }
}
