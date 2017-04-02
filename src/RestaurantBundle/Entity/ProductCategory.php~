<?php

namespace RestaurantBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * ProductCategory
 */
class ProductCategory {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $products;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $created;

    /**
    * @var \DateTime
    */
    private $updated;

    public function __construct() {

        $this->products = new ArrayCollection();
        $this->created = new \DateTime();
    }

    public function __toString() {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set products
     *
     * @param string $products
     *
     * @return ProductCategory
     */
    public function setProducts($products) {
        $this->products = $products;

        return $this;
    }

    /**
     * Get products
     *
     * @return string
     */
    public function getProducts() {
        return $this->products;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ProductCategory
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ProductCategory
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ProductCategory
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return ProductCategory
     */
    public function setModified($modified) {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified() {
        return $this->modified;
    }


    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return ProductCategory
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add product
     *
     * @param \RestaurantBundle\Entity\Product $product
     *
     * @return ProductCategory
     */
    public function addProduct(\RestaurantBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \RestaurantBundle\Entity\Product $product
     */
    public function removeProduct(\RestaurantBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }
}
