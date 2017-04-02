<?php

namespace RestaurantBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class TelType extends AbstractType
{
    
    /**
     * @return  string
     */
    public function getName()
    {
        return 'tel';
    }
    
    /**
     * @return  string
     */
    public function getParent()
    {
        return 'text';
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['type'] = 'tel';
    }
}
