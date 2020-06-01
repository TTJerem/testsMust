<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\Table(name="product")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $url;

    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @ORM\Column(type="text")
     *
     */
    private $description;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @ORM\Column(type="boolean")
     *
     */
    private $active;

    public function isActive()
    {
        return $this->active;
    }

    /**
     * @ORM\OneToOne(targetEntity="Brand", cascade={"persist"})
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id", nullable=true)
     */
    private $brand;

    /**
     * @ORM\ManyToMany(targetEntity="Category")
     * @ORM\JoinTable(name="products_categories",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     *      )
     */
    private $categories;

    public function __construct() {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
