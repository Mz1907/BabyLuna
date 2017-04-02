<?php

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class ImageMenuAdmin extends AbstractAdmin {

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('menu', 'sonata_type_model', array(
                    'label' => 'A quel menu appartient cette image ?',
                ))
                ->add('file', 'file', array(
                    'required' => false,
                    'label' => 'Image du produit'
                ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('filename')
                ->add('alt')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('filename')
                ->addIdentifier('alt')
                ->addIdentifier('product')
        ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('filename')
                ->add('alt')
                ->add('product')
        ;
    }

    public function prePersist($image) {
        $this->manageImageUpload($image);
    }

    public function postPersist($image) {
        $this->manageImageUpload($image);
    }

    public function preUpdate($image) {
        $this->manageImageUpload($image);
    }

    private function manageImageUpload($image) {
        if ($image->getFile()) {
            $image->refreshUpdated();

            //Insèrtion l'attribut "alt" de l'image qui est le slug du produit associé
            $image->setAlt($image->getMenu()->getName());
        }
    }

}
