<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $utl;

    /**
     * @ORM\Column(type="integer")
     */
    private $publishDate;

    /**
     * @ORM\Column(type="smallint")
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $lang;

    /**
     * @ORM\Column(type="string", length=5000, nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $feedLink;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="posts")
     */
    private $category;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $views;

    public function __construct()
    {
        $this->category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUtl(): ?string
    {
        return $this->utl;
    }

    public function setUtl(string $utl): self
    {
        $this->utl = $utl;

        return $this;
    }

    public function getPublishDate(): ?int
    {
        return $this->publishDate;
    }

    public function setPublishDate(int $publishDate): self
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(int $active): self
    {
        $this->active = $active;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getFeedLink(): ?string
    {
        return $this->feedLink;
    }

    public function setFeedLink(?string $feedLink): self
    {
        $this->feedLink = $feedLink;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(?int $views): self
    {
        $this->views = $views;

        return $this;
    }
}
