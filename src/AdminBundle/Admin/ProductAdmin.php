<?php

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class ProductAdmin extends AbstractAdmin {

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {        
        $formMapper
                ->add('name', 'text', array(
                    'required' => true,
                    'label' => 'Nom du produit'
                ))
                ->add('description', 'text', array(
                    'label' => 'Description du produit',
                    'required' => false,
                ))
                ->add('productCategories', 'sonata_type_model', array(
                    'required' => true,
                    'multiple' => true,
                    'label' => 'Catégorie(s) du produit',
                ))
                ->add('price', 'text', array(
                    'required' => false,
                    'label' => 'Prix du produit'
                ))
                ->add('available', 'checkbox', array(
                    'required' => false,
                    'label' => 'Le produit est-il actuellement disponible ?'
                ))
                ->add('takeAway', 'checkbox', array(
                    'required' => false,
                    'label' => 'Le produit peut-il être emporté sur place ?'
                ))
                
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('name')
                ->add('slug')
                ->add('description')
                ->add('productCategories')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('name')
                ->addIdentifier('slug')
                ->add('description')
                ->add('price')
                ->add('available')
                ->add('takeAway')
        ;
    }
    
}
