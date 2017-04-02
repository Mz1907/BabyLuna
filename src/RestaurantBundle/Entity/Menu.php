<?php

namespace RestaurantBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Menu
 */
class Menu {

    /**
     * @var int
     */
    private $id;

    /**
     * @var array
     */
    private $images;
    
    /**
     * @var array
     */
    private $products;

    /**
     * @var string
     */
    private $name;
    
    private $dateStart;

    /**
     * @var \DateTime
     * 
     * @Assert\Expression(
     *     "this.validateDateMenu(this.getDateStart(), this.getDateEnd())",
     *     message="La durée de validité d'un menu doit être d'au moins 1 heure"
     * )
     */
    private $dateEnd;

    /**
     * @var string
     */
    private $price;

    /**
     * @var bool
     */
    private $takeAway;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $updated;

    public function __construct() {
        /*
         * (Pour sonata admin) Date de début de validité du menu et date de fin de validité sont égaux: 
         * ainsi par défaut le menu possède une date de validité dépassée
         * note: je met h:i:s à 0 pour + de clareté
         */
        $currentDate = new \DateTime();
        $currentDate->setTime(0, 0, 0);
        $this->dateStart = $currentDate;
        $this->dateEnd = $currentDate;

        $this->images = new ArrayCollection(); // gestion relation produit-images
        $this->products = new ArrayCollection(); // gestion relation produit-menus


        $this->takeAway = false;
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /* Permet d'afficher une liste de tout les menus, lors de l'insertion d'une image */
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
     * Set name
     *
     * @param string $name
     *
     * @return Menu
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
     * Set dateStart
     *
     * @param \DateTime $dateStart
     *
     * @return Menu
     */
    public function setDateStart($dateStart) {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime
     */
    public function getDateStart() {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return Menu
     */
    public function setDateEnd($dateEnd) {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd() {
        return $this->dateEnd;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Menu
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set takeAway
     *
     * @param boolean $takeAway
     *
     * @return Menu
     */
    public function setTakeAway($takeAway) {
        $this->takeAway = $takeAway;

        return $this;
    }

    /**
     * Get takeAway
     *
     * @return bool
     */
    public function getTakeAway() {
        return $this->takeAway;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Menu
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
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Menu
     */
    public function setUpdated($updated) {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Set images
     *
     * @param array $images
     *
     * @return Menu
     */
    public function setImages($images) {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages() {
        return $this->images;
    }
    
    /**
     * Set products
     *
     * @param array $products
     *
     * @return Menu
     */
    public function setProducts($products) {
        $this->products = $products;

        return $this;
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts() {
        return $this->products;
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
     * @var string
     */
    private $message;

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Menu
     */
    public function setMessage($message) {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * Add image
     *
     * @param \RestaurantBundle\Entity\ImageMenu $image
     *
     * @return Menu
     */
    public function addImage(\RestaurantBundle\Entity\ImageMenu $image) {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \RestaurantBundle\Entity\ImageMenu $image
     */
    public function removeImage(\RestaurantBundle\Entity\ImageMenu $image) {
        $this->images->removeElement($image);
    }

    /**
     * Vérifie que (dateFin - dateDebut) > 3600
     * 
     * @param DateTime $dateStart
     * @param DateTime $dateEnd
     * 
     * @return boolean
     */
    public function validateDateMenu($dateStart, $dateEnd) {
        $stampStart = $dateStart->getTimeStamp();
        $stampEnd = $dateEnd->getTimeStamp();
        $diff = $stampEnd - $stampStart;

        if ($diff < 3600)
            return false;
        return true;
    }


    /**
     * Add product
     *
     * @param \RestaurantBundle\Entity\Product $product
     *
     * @return Menu
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
