<?php

namespace Packed\Bundle\ScoreModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SectieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('waarde',null,array('label' => 'Label sectie NL'))
            ->add('waarde_en',null,array('label' => 'Label sectie EN'))
            ->add('intro',null,array('label' => 'Introductietekst NL'))
            ->add('intro_en',null,array('label' => 'Introduktietekst EN'))
            ->add('volgorde',null,array('label' => 'Volgorde'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Packed\Bundle\ScoreModelBundle\Entity\Sectie'
        ));
    }

    public function getName()
    {
        return 'packed_bundle_scoremodelbundle_sectietype';
    }
}
