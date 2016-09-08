<?php

namespace Packed\Bundle\ScoreModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('waarde',null,array('label' => 'Label eis NL'))
            ->add('waarde_en',null,array('label' => 'Label eis EN'))
            ->add('context',null,array('label' => 'Context NL'))
            ->add('context_en',null,array('label' => 'Context EN'))
            ->add('risico',null,array('label' => 'Risico NL'))
            ->add('risico_en',null,array('label' => 'Risico EN'))
            ->add('voorbeeld',null,array('label' => 'Voorbeeld NL'))
            ->add('voorbeeld_en',null,array('label' => 'Voorbeeld EN'))
            ->add('actie',null,array('label' => 'Actie NL'))
            ->add('actie_en',null,array('label' => 'Actie EN'))
            ->add('bronnen',null,array('label' => 'Bronnen NL'))
            ->add('bronnen_en',null,array('label' => 'Bronnen EN'))
            ->add('risiconiveau','choice',array(
            'choices'   => array(
                'A'   =>   'A',
                'B'   =>   'B',
                'C'   =>   'C',
            ),
                    'label' => 'Risiconiveau'))

            ->add('oaisMagenta',null,array('label' => 'OAIS Magenta'))
            ->add('volgorde',null,array('label' => 'Volgorde'))
            ->add('sectie')
            ->add('opmerkingen', null, array('label' => 'Opmerkingen (worden niet getoond)'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Packed\Bundle\ScoreModelBundle\Entity\Eis'
        ));
    }

    public function getName()
    {
        return 'packed_bundle_scoremodelbundle_eistype';
    }
}
