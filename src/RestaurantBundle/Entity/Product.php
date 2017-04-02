<?php

namespace RestaurantBundle\Entity;

use RestaurantBundle\Entity\ProductCategory;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Product
 */
class Product {

    const SERVER_PATH_TO_IMAGE_FOLDER = __DIR__ . '/../../../web/ImagesProduct';

    /**
     * @var int
     */
    private $id;

    /**
     * @var array
     */
    private $productCategories;
    
    /**
     * @var array
     */
    private $menus;

    /**
     * @var array
     */
    private $images;


    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $price;

    /**
     * @var bool
     */
    private $available;

    /**
     * @var boolean
     */
    private $takeAway;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $updated;

    public function __construct() {
        $this->productCategories = new ArrayCollection(); //gestion relation produit-categories
        $this->menus = new ArrayCollection();
        $this->images = new ArrayCollection(); // gestion relation produit-images
        $this->available = false;
        $this->takeAway = false;
        $this->created = new \DateTime();
    }

    /* 
     * J'implémente la méthode toString pour pouvoir afficher une liste select des produits 
     * dans SonataAdminBundle (pour le form d'upload d'images)
     */
    public function __toString() {
        return $this->name;
    }
    
     /**
     * Gestion des relations 
     */
    //Note le singulier, on ajoute une seule catégorie à la fois
    public function addProductCategory(ProductCategory $productCategory) {
        // Ici, on utilise l'ArrayCollection comme un tableau
        $this->productCategories[] = $productCategory;

        return $this;
    }

    public function removeProductCategory(ProductCategory $productCategory) {
        // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
        $this->productCategories->removeElement($productCategory);
    }

    // Idem que pour la gestion des catgories plus haut (necessaire pour SonataAdminBundle)
    public function addImage(Image $image) {
        $this->images[] = $image;

        return $this;
    }

    public function removeImage(Image $image) {
        $this->images->removeElement($image);
    }
    

    /** Fin gestion des relations * */

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set productCategories
     *
     * @param array $productCategories
     *
     * @return Product
     */
    public function setProductCategories($productCategories) {
        $this->productCategories = $productCategories;

        return $this;
    }

    /**
     * Get productCategories
     *
     * @return array
     */
    public function getProductCategories() {
        return $this->productCategories;
    }

    /**
     * Set images
     *
     * @param array $images
     *
     * @return Product
     */
    public function setImages($images) {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return array
     */
    public function getImages() {
        return $this->images;
    }
    
    /**
     * Set menus
     *
     * @param array $menus
     *
     * @return Product
     */
    public function setMenus($menus) {
        $this->menus = $menus;

        return $this;
    }

    /**
     * Get menus
     *
     * @return array
     */
    public function getMenus() {
        return $this->menus;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
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
     * @return Product
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
     * Set price
     *
     * @param integer $price
     *
     * @return Product
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set available
     *
     * @param boolean $available
     *
     * @return Product
     */
    public function setAvailable($available) {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available
     *
     * @return bool
     */
    public function getAvailable() {
        return $this->available;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Product
     */
    public function setCreated($created) {
        $this->added = $added;

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
     * Set takeAway
     *
     * @param boolean $takeAway
     *
     * @return Product
     */
    public function setTakeAway($takeAway) {
        $this->takeAway = $takeAway;

        return $this;
    }

    /**
     * Get takeAway
     *
     * @return boolean
     */
    public function getTakeAway() {
        return $this->takeAway;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return News
     */
    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated() {
        return $this->updated;
    }


    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Product
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }
    
}
