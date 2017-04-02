<?php

namespace RestaurantBundle\Controller\ReservationController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use RestaurantBundle\Entity\Reservation;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use RestaurantBundle\Form\Type\TelType;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;

class ReservationController extends Controller
{

    public function showFormAction(Request $request)
    {
        $form = $this->buildFormAction();

        //hydrate l'objet form. 
        $form->handleRequest($request);

        //method isValid(à ne fait que regarder s'il y a des erreur de constrainte
        if ($form->isSubmitted() && $form->isValid())
        {
            $reservation = $form->getData();
            $reservationMessage = $this->persistAndMailAction($reservation);
        }

        $vars = ['formReservation' => $form->createView()];

        if (isset($reservationMessage))
        {
            $bootstrapMessage = ($reservationMessage == 'Votre réservation a bien été enregistrée') ? 'alert alert-success' : 'alert alert-error';
            $vars['messageClass'] = $bootstrapMessage;
            $vars['reservationMessage'] = $reservationMessage;
        }
        return $this->render('RestaurantBundle:Front/Reservation:reservation.html.twig', ['vars' => $vars]);
    }

    public function persistAndMailAction(Reservation $reservation)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($reservation);
        $em->flush();
        //if flushed envoie email
        if ($reservation->getId())
        {
            $messageReservation = 'Votre réservation a bien été enregistrée';

            //$this->sendMailAction($reservation, 'xxx@gmail.com');
            //$this->sendMailAction($reservation, 'xxx@gmail.com');
        } else
        {
            $messageReservation = 'Votre réservation n\'a pu être enregistré. Veuillez réessayer s\'il vous plaît';
        }
        return $messageReservation;
    }

    /**
     * Renvoi un formulaire de reservation à afficher
     * @return FormBuilder
     */
    public function buildFormAction()
    {
        $reservation = new Reservation();
        $countGuestOptions = $this->countGuestOptionsAction();
        $userPhoneOptions = $this->userPhoneOptionAction();
        $userNameOption = $this->userNameOptionAction();
        //$recaptchaOption = $this->recaptchaOptionsAction();
        
        return $this->createFormBuilder($reservation)
                        ->setAction($this->generateUrl('reservation_form'))->setMethod('POST')
                        ->add('dateReservation', DateType::class, array('widget' => 'single_text',
                            'format' => 'dd-MM-yyyy',
                            'required' => true))
                        ->add('timeReservation', TimeType::class, array('widget' => 'single_text',
                            'required' => true))
                        ->add('countGuest', ChoiceType::class, $countGuestOptions)
                        ->add('userName', TextType::class, $userNameOption)
                        ->add('userMail', EmailType::class, array('label' => 'E-mail de contact',
                            'attr' => array('class' => 'form-control', 'placeholder' => 'Votre e-mail')
                        ))
                        ->add('userPhone', TelType::class, $userPhoneOptions)
                        //->add('recaptcha', EWZRecaptchaType::class, $recaptchaOption)
                        ->add('save', SubmitType::class, array('label' => 'Réserver',
                            'attr' => array('class' => 'btn btn-xl btn-dark btn-block',
                            'style' => 'margin-top:20px;')
                        ))
                        ->getForm();
    }

    /**
     * 
     * @return array
     */
    public function countGuestOptionsAction()
    {
        return $otpionsGuest = array(
            'label' => 'Nombre de personnes',
            'required' => true,
            'choices' => array(
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
                '6' => 6,
                '7' => 7,
                '8' => 8,
                '9' => 9,
                '10' => 10,
                '10+' => 11
            ),
            'attr' => array(
                'class' => 'form-control'
            )
        );
    }

    /**
     *
     * @return array
     */
    public function userPhoneOptionAction()
    {
        return $userPhoneOption = array(
            'label' => 'N° téléphone de contact',
            'required' => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Votre numéro de téléphone (requis)'
            )
        );
    }

    /**
     * 
     * @return array
     */
    public function userNameOptionAction()
    {
        return $userNameOption = array(
            'label' => 'Nom de contact',
            'required' => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Votre nom (requis)'
            )
        );
    }
    
    /**
     * 
     * @return array
     */
    public function recaptchaOptionsAction()
    {
        return $optionRecaptcha = array(
                            'label' => 'Je ne suis pas un robot',
                            'attr' => array('options' => array('theme' => 'light',
                                    'type' => 'image',
                                    'size' => 'normal',
                                    'defer' => true,
                                    'async' => true,
                                    'language' => 'fr'
                                )
                            )
                        );
    }

    /**
     * 
     * @param Reservation $reservation
     */
    public function sendMailAction(Reservation $reservation, $to)
    {
        $resDate = $reservation->getDateReservation();
        $resTime = $reservation->getTimeReservation();
        $userMail = $reservation->getUserMail() == '' ? false : $reservation->getUserMail();

        $mail = \Swift_Message::newInstance('Une nouvelle réservation a été reçue.')
                ->setSubject('Nouvelle réservation enregistrée.')
                ->setFrom('xxx@gmail.com')
                ->setTo($to)
                ->setBody($this->renderView(
                        'Emails/newReservation.html.twig', ['dateReservation' => $resDate->setTime($resTime->format('H'), $resTime->format('i')),
                    'countGuest' => $reservation->getCountGuest(),
                    'userName' => $reservation->getUserName(),
                    'userPhone' => $reservation->getUserPhone(),
                    'userMail' => $reservation->getUserMail()
                        ]
                ), 'text/html');

        $this->get('mailer')->send($mail);
    }

}
