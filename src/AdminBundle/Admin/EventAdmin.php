<?php

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class EventAdmin extends AbstractAdmin {

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('title', 'text', array(
                    'required' => true,
                    'label' => 'Nom de l\'événement'
                ))
                ->add('dateStart', 'datetime', array(
                    'required' => true,
                    'label' => 'Date de début de l\'événement',
                ))
                ->add('dateEnd', 'datetime', array(
                    'required' => true,
                    'label' => 'Date de fin de l\'événement',
                ))
                ->add('message', CKEditorType::class, array(
                    'label' => 'Message',
                    'filebrowsers' => array(
                        'ImageBrowseUrl',
                        'ImageBrowseLinkUrl'
                    )
                ))
                ->add('category', 'choice', array(
                    'required' => true,
                    'choices' => array(
                        'Promotion' => 'Promotion',
                        'Événement spécial' => 'Événement'
                    )
                ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('title')
                ->add('dateStart')
                ->add('dateEnd')
                ->add('description')
                ->add('category')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('title')
                ->addIdentifier('dateStart')
                ->add('dateEnd')
                ->add('description')
                ->add('category')
        ;
    }

}
