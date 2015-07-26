<?php

namespace JSB\CasinoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('montant')
            ->add('description')
            //->add('dateHeure')
            //->add('personne')
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'JSB\CasinoBundle\Entity\Transaction'
        ));
        
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jsb_casinobundle_transaction';
    }
}
