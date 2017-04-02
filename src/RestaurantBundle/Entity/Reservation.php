<?php

namespace RestaurantBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints as Recaptcha;


/**
 * Reservation
 */
class Reservation
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     * 
     * @Assert\Expression(
     *     "this.checkDateReservation(this.getDateReservation())",
     *     message="Au maximum, une reservation peut être effectuée 6 mois à l'avance. Merci pour votre compréhension."
     * )
     */
    private $dateReservation;

    /**
     * @var \DateTime
     * 
     * @Assert\Expression(
     * "this.checkTimeReservation(this.getTimeReservation())",
     * message="Une réservation permet de réserver une table entre 12h30 - 14h00 et 18h30 - 22h30. Merci pour votre compréhension."
     * )
     * 
     */
    private $timeReservation;

    /**
     * @var string
     */
    private $userName;

    /**
     * @var string
     */
    private $userMail;

    /**
     * @var string
     */
    private $userPhone;

    /**
     * @var integer
     */
    private $countGuest;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $updated;

    /**
     * @Recaptcha\IsTrue
     */
    public $recaptcha;

    public function __construct()
    {
        $this->created = new \Datetime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateReservation
     *
     * @param \DateTime $dateReservation
     *
     * @return Reservation
     */
    public function setDateReservation($dateReservation)
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    /**
     * Get dateReservation
     *
     * @return \DateTime
     */
    public function getDateReservation()
    {
        return $this->dateReservation;
    }

    /**
     * Set timeReservation
     *
     * @param \DateTime $timeReservation
     *
     * @return Reservation
     */
    public function setTimeReservation($timeReservation)
    {
        $this->timeReservation = $timeReservation;

        return $this;
    }

    /**
     * Get timeReservation
     *
     * @return \DateTime
     */
    public function getTimeReservation()
    {
        return $this->timeReservation;
    }

    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return Reservation
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
     * @return Reservation
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
     * @return Reservation
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
     * Set countGuest
     *
     * @param integer $countGuest
     *
     * @return Reservation
     */
    public function setCountGuest($countGuest)
    {
        $this->countGuest = $countGuest;

        return $this;
    }

    /**
     * Get countGuest
     *
     * @return integer
     */
    public function getCountGuest()
    {
        return $this->countGuest;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Reservation
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

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Reservation
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
     * Vérifie que la date de réservation soit cohérente. Date de reservation ne peut être plus petite que $current
     * Et date de reservation ne peut être supérieur à 6 mois.
     * @return boolean
     */
    public function checkDateReservation($dateReservation)
    {
        if ($dateReservation instanceof \DateTime)
        {
            $current = new \DateTime();
            if ($current < $dateReservation)
            {
                $diffTemp = $current->diff($dateReservation);
                $diff = intval($diffTemp->format('%R%a'));
                return $diff < 184;
            }
            return false;
        }
        return false;
    }

    /**
     * Vérifie que l'heure de réservation soit cohérente. Entre 12h30 et 14h ou entre 18h30 et 22h
     * @return boolean
     */
    public function checkTimeReservation($timeReservation)
    {
        if ($timeReservation instanceof \DateTime)
        {
            $today = new \DateTime();

            $timeReservation = $today->createFromFormat('H:i', $timeReservation->format('H:i'));
            $openingMidDay = $today->createFromFormat('H:i', '12:30');
            $closingMidDay = $today->createFromFormat('H:i', '14:00');

            $openingEvening = $today->createFromFormat('H:i', '18:30');
            $closingEvening = $today->createFromFormat('H:i', '22:00');

            if ($timeReservation < $openingMidDay || $timeReservation > $closingEvening)
            {
                return false;
            } elseif ($timeReservation > $closingMidDay && $timeReservation < $openingEvening)
            {
                return false;
            }
            return true;
        }
        return false;
    }
}
