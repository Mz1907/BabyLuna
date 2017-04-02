<?php

namespace RestaurantBundle\Entity;

use EWZ\Bundle\RecaptchaBundle\Validator\Constraints as Recaptcha;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contact
 */
class Contact
{

    /**
     * @var int
     */
    private $id;

    /**
     * 
     * @var string
     * 
     * @Assert\Length(
     *      min = 3,
     *      max = 30,
     *      minMessage = "Votre numéro de téléphone doit faire au moins 3 caractères",
     *      maxMessage = "Votre numéro de téléphone doit faire au plus 30 caractères"
     * )
     * 
     */
    private $userName;

    /**
     * @var string
     * 
     */
    private $userMail;

    /**
     * 
     * @Assert\Length(
     *      min = 8,
     *      max = 40,
     *      minMessage = "Votre nom de contact doit faire au moins 8 caractères",
     *      maxMessage = "Votre nom de contact doit faire au plus 40 caractères"
     * )
     * @var string
     */
    private $userPhone;

    /**
     * @var string
     * 
     * 
     * @Assert\Length(
     *     min = 10,
     *     max = 500,
     *     minMessage = "Votre message doit faire au moins 10 caractères",
     *     maxMessage = "Votre message doit faire au plus 500 caractères"
     * )
     */
    private $message;

    /**
     * @var bool
     */
    private $subscribeNewsletter;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @Recaptcha\IsTrue
     */
    public $recaptcha;

    public function __construct()
    {
        $this->subscribeNewsletter = true;
        $this->created = new \DateTime();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return Contact
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set userMail
     *
     * @param string $userMail
     *
     * @return Contact
     */
    public function setUserMail($userMail)
    {
        $this->userMail = $userMail;

        return $this;
    }

    /**
     * Get userMail
     *
     * @return string
     */
    public function getUserMail()
    {
        return $this->userMail;
    }

    /**
     * Set userPhone
     *
     * @param string $userPhone
     *
     * @return Contact
     */
    public function setUserPhone($userPhone)
    {
        $this->userPhone = $userPhone;

        return $this;
    }

    /**
     * Get userPhone
     *
     * @return string
     */
    public function getUserPhone()
    {
        return $this->userPhone;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Contact
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set subscribeNewsletter
     *
     * @param boolean $subscribeNewsletter
     *
     * @return Contact
     */
    public function setSubscribeNewsletter($subscribeNewsletter)
    {
        $this->subscribeNewsletter = $subscribeNewsletter;

        return $this;
    }

    /**
     * Get subscribeNewsletter
     *
     * @return bool
     */
    public function getSubscribeNewsletter()
    {
        return $this->subscribeNewsletter;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Contact
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

}
