<?php

namespace RestaurantBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ImageMenu
 */
class ImageMenu {

    const SERVER_PATH_TO_IMAGE_FOLDER = __DIR__ . '/../../../web/ImagesMenu';
    /**
     * @var int
     */
    private $id;

    /**
     * @var Menu
     */
    private $menu;

    /**
     * @var string
     */
    private $alt;
    
    /**
     * Fichier image
     * Entité non mapée pour manipuler l'upload d'images
     */
    protected $file;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $updated;
    
    public function __construct() {
        $this->created = new \DateTime();
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
     * Set alt
     *
     * @param string $alt
     *
     * @return ImageMenu
     */
    public function setAlt($alt) {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt() {
        return $this->alt;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ImageMenu
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
     * @return ImageMenu
     */
    public function setUpdated($updated) {
        $this->updated = $updated;

        return $this;
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
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null) {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return Image
     */
    public function setFilename($filename) {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename() {
        return $this->filename;
    }

    /**
     * Manages the copying of the file to the relevant place on the server
     */
    public function upload() {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and target filename as params
        //$fileName = md5(uniqid()).'.'.$this->getFile()->guessExtension();
        $this->getFile()->move(
                self::SERVER_PATH_TO_IMAGE_FOLDER, $this->getFile()->getClientOriginalName()
        );



        // set the path property to the filename where you've saved the file
        $this->filename = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }

    /**
     * Lifecycle callback to upload the file to the server
     */
    public function lifecycleFileUpload() {
        $this->upload();
    }

    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire
     */
    public function refreshUpdated() {
        $this->setUpdated(new \DateTime());
    }

    /**
     * @var string
     */
    private $filename;



    /**
     * Set menu
     *
     * @param \RestaurantBundle\Entity\Menu $menu
     *
     * @return ImageMenu
     */
    public function setMenu(\RestaurantBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \RestaurantBundle\Entity\Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }
}
