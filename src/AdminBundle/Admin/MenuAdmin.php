<?php

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class MenuAdmin extends AbstractAdmin {

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('name', 'text', array(
                    'required' => true,
                    'label' => 'Nom du menu ',
                ))
                ->add('dateStart', 'datetime', array(
                    'required' => true,
                    'label' => 'Début de validité du menu',
                ))
                ->add('dateEnd', 'datetime', array(
                    'required' => true,
                    'label' => 'Fin de validité du menu',
                ))
                ->add('products', 'sonata_type_model', array(
                    'required' => true,
                    'multiple' => true,
                    'label' => 'Quels sont les produits qui composent le menu ?',
                ))
                ->add('message', CKEditorType::class, array(
                    'label' => 'Message optionel de présentation du menu',
                ))
                ->add('price', 'text', array(
                    'required' => false,
                    'label' => 'Prix du menu'
                ))
                ->add('takeAway', 'checkbox', array(
                    'required' => false,
                    'label' => 'Le menu peut-il être emporté sur place ?'
                ))

        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('name')
                ->add('products')
                ->add('message')
                ->add('dateStart')
                ->add('dateEnd')
                ->add('price')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('name')
                ->add('products')
                ->add('message')
                ->add('dateStart')
                ->add('dateEnd')
                ->add('price')
                ->add('takeAway')
                ->add('created')
        ;
    }

}
