<?php

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class ReservationAdmin extends AbstractAdmin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('dateReservation', 'date', array(
                    'label' => 'Jour de réservation',
                    'required' => true
                ))
                ->add('timeReservation', 'datetime', array(
                    'label' => 'Heure de réservation',
                    'required' => true,
                    'date_format' => 'HH:mm'
                ))
                ->add('countGuest', 'choice', array(
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
                    )
                ))
                ->add('userName', 'text', array(
                    'label' => 'Nom de contact',
                    'required' => true
                ))
                ->add('userPhone', 'text', array(
                    'label' => 'Téléphone de contact',
                    'required' => true
                ))
                ->add('userMail', 'text', array(
                    'label' => 'E-mail de contact',
                    'required' => false
                ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('id')
                ->add('dateReservation')
                ->add('timeReservation')
                ->add('userName')
                ->add('userMail')
                ->add('userPhone')
                ->add('created')
                ->add('updated')
        ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
                ->addIdentifier('id')
                ->add('dateReservation')
                ->add('timeReservation')
                ->add('userName')
                ->add('userMail')
                ->add('userPhone')
                ->add('created')
                ->add('updated')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('id')
                ->add('dateReservation')
                ->add('timeReservation')
                ->add('userName')
                ->add('userPhone')
                ->add('userMail')
                ->add('created')
                ->add('updated')
        ;
    }
    

}
