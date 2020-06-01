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

    /**
     * Public getter for Product ID
    */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $name;

    /**
     * Public getter for Product Name
    */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Public setter for Product Name
    */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $url;

    /**
     * Public getter for Product URL
    */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Public setter for Product URL
    */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @ORM\Column(type="text")
     *
     */
    private $description;

    /**
     * Public getter for Product description
    */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Public setter for Product description
    */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @ORM\Column(type="boolean")
     *
     */
    private $active = true;

    /**
     * Public getter for Product active boolean
    */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Public setter for Product active boolean
    */
    public function setActive($active)
    {
        if(!is_null($active))
        {
            $this->active = $active;
        }
    }

    /**
     * @ORM\OneToOne(targetEntity="Brand", cascade={"persist"})
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id", nullable=true)
     */
    private $brand;

    /**
     * Public getter for the Product Brand, can be null
    */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Public getter for the Product Brand, can be null
    */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * @ORM\ManyToMany(targetEntity="Category")
     * @ORM\JoinTable(name="products_categories",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     *      )
     */
    private $categories;

    /**
     * Public getter for Product Categories, array of categories, can be empty
    */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Public setter for Product Categories, array of categories, can be empty
    */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
    * Private field representing the Product ID in MD5
    * Not saved in Database
    */
    private $md5;

    public function getMd5()
    {
        return md5($this->id);
    }

    /**
     * Initialize field
    */
    public function __construct() {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
