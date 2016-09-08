<?php

namespace Packed\Bundle\ScoreModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RapportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('naam')
            ->add('score')
            ->add('grafiek')
            ->add('datumGeneratie')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Packed\Bundle\ScoreModelBundle\Entity\Rapport'
        ));
    }

    public function getName()
    {
        return 'packed_bundle_scoremodelbundle_rapporttype';
    }
}
