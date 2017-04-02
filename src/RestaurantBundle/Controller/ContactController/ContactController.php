<?php

namespace RestaurantBundle\Controller\ContactController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use RestaurantBundle\Entity\Contact;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use RestaurantBundle\Form\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;

class ContactController extends Controller
{

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function showFormAction(Request $request)
    {
        $form = $this->buildForm();

        //hydrate l'objet form. 
        $form->handleRequest($request);
        
        //method isValid(ne fait que regarder s'il y a des erreur de constraint)
        if ($form->isSubmitted() && $form->isValid())
        {
            $contact = $form->getData();
            $contactMessage = $this->persistAndMailAction($contact);
        }

        $vars = ['formContact' => $form->createView()];

        return $this->render('RestaurantBundle:Front\Contact:contact.html.twig', ['vars' => $vars]);
    }

    /**
     * 
     * @return type
     */    
    public function buildForm()
    {
        $contact = new Contact();
        $userPhoneOptions = $this->userPhoneOptionAction();
        $userNameOption = $this->userNameOptionAction();
        $recaptchaOption = $this->recaptchaOptionsAction();

        return $this->createFormBuilder($contact)
                        ->setAction($this->generateUrl('contact_form'))->setMethod('POST')
                        ->add('userName', TextType::class, $userNameOption)
                        ->add('userMail', EmailType::class, array('attr' => array('class' => 'form-control',
                            'placeholder' => 'Votre e-mail (requis)')                         
                        ))
                        ->add('userPhone', TelType::class, $userPhoneOptions)
                        ->add('message', TextareaType::class, array('attr' => array('class' => 'form-control',
                            'placeholder' => 'Votre message (requis)',
                            'rows' => 10)
                        ))
                        ->add('subscribeNewsletter', CheckboxType::class, array('label' => 'Être informé par e-mail des promotions du restaurant',
                            'attr' => array('class' => 'form-check-inline'),
                            'required' => false))
                        ->add('recaptcha', EWZRecaptchaType::class, $recaptchaOption)
                        ->add('save', SubmitType::class, array('label' => 'Envoyer',
                            'attr' => array('class' => 'btn btn-rounded btn-primary')
                        ))
                        ->getForm();
    }

    /**
     * 
     * @return array
     */
    public function userNameOptionAction()
    {
        return $userNameOption = array(
            'required' => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Nom de contact (requis)'
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
     * @return array
     */
    public function userPhoneOptionAction()
    {
        return $userPhoneOption = array(
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'N° téléphone de contact (facultatif)'
            )
        );
    }

    /**
     * 
     * @param Contact $contact
     * @return string
     */
    public function persistAndMailAction(Contact $contact)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($contact);
        $em->flush();
        //if flushed envoie email
        if ($contact->getId())
        {
            $messageContact = 'Votre message a bien été envoyé';

            $this->sendMailAction($contact, 'zm.mail02@gmail.com');
            //$this->sendMailAction($contact, 'zagai.mehdi@gmail.com');
        } else
        {
            $messageContact = 'Votre message n\'a pu être envoyé. Veuillez réessayer s\'il vous plaît';
        }
        return $messageContact;
    }

    /**
     * 
     * @param Contact $contact
     */
    public function sendMailAction(Contact $contact, $to)
    {
        $userName = $contact->getUserName();
        $userMail = $contact->getUserMail();
        $userPhone = $contact->getUserPhone() == '' ? false : $contact->getUserPhone();
        $message = $contact->getMessage();
        
        $mail = \Swift_Message::newInstance('Un nouveau message a été reçu (formulaire de contact).')
                ->setSubject('Nouveau message du formulaire de contact.')
                ->setFrom('sdz.code@gmail.com')
                ->setTo($to)
                ->setBody($this->renderView(
                    'Emails/contact.html.twig', [
                    'dateMessage' => $contact->getCreated(),
                    'userName' => $contact->getUserName(),
                    'userEmail' => $contact->getUserMail(),
                    'userPhone' => $contact->getUserPhone(),
                    'message' => $contact->getMessage()
                        ]
                ), 'text/html');

        $this->get('mailer')->send($mail);
    }

}
