<?php

namespace RestaurantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of RegistrationType
 *
 * @author Admin
 */
class RegistrationType extends AbstractType
{

//    public function buildForm(FormBuilderInterface $builder, array $options)
//    {
//        $builder->add('firstName');
//        $builder->add('lastName');
//        $builder->add('birthdate', 'birthday');
//        $builder->add('adress');
//        $builder->add('zip');
//        $builder->add('country');
//    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

}
