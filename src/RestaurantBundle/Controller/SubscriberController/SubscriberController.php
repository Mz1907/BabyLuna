<?php

namespace RestaurantBundle\Controller\SubscriberController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use RestaurantBundle\Entity\Subscriber;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

/**
 *
 * @author zmmai
 */
class SubscriberController extends Controller
{
    /*
     * 
     */

    public function showFormAction(Request $request)
    {
        $form = $this->buildFormAction();

        //hydrate l'objet form. 
        $form->handleRequest($request);

        //method isValid(à ne fait que regarder s'il y a des erreur de constrainte
        if ($form->isSubmitted() && $form->isValid())
        {
            $subscriber = $form->getData();
            $messageSubscription = $this->persistSubscriber($reservation);
        }
        //TODO Implémenter ce formulaire sur la home page pour qu'il soit traiter
    }

    /*
     * 
     */

    public function buildFormAction()
    {
        $subscriber = new Subscriber();
        return $this->createFormBuilder()
                        ->add('userMail', EmailType::class, array('attr' => array('class' => 'form-control'
                                , 'placeholder' => 'Votre e-mail')
        ));
    }
    
    public function persistSubscriber(Subscriber $subscriber)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($subscriber);
        $em->flush();
        
        if($subscriber->getId())
        {
            //le subscriber a bien été flushé
            $messageSubscription = "Vous êtes bien abonné à notre newsletter.";
        }
        else
        {
            $messageSubscription = "Il y a eu un problème lors de votre inscription. Veuillez nous en excuser.";
        }
        
        return $messageSubscription;
    }

}
