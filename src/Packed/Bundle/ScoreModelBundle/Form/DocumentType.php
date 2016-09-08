<?php

namespace Packed\Bundle\ScoreModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array("label"=> "Naam"))
            ->add('beschrijvingNl', null,  array("label"=> "Beschrijving NL"))
            ->add('beschrijvingEn', null,  array("label"=> "Beschrijving EN"))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Packed\Bundle\ScoreModelBundle\Entity\Document'
        ));
    }

    public function getName()
    {
        return 'packed_bundle_scoremodelbundle_documenttype';
    }
}
