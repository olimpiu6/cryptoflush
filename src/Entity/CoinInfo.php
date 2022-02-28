<?php

namespace App\Entity;

use App\Repository\CoinInfoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoinInfoRepository::class)
 */
class CoinInfo
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
    private $ticker;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lang;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $jsonData = [];

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(string $lang): self
    {
        $this->lang = $lang;

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
