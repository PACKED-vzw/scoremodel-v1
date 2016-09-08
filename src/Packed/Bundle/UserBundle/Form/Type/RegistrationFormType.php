<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Packed\Bundle\UserBundle\Form\Type;


use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            parent::buildForm($builder, $options);

            $builder
            ->add('organisatie', null, array('label' => 'Organisatie' ))
            ->add('typeOrganisatie', 'choice',
                    array(
                    'choices'=>(array(
                            'archief'=>'registratie.type.archief',
                            'bibliotheek'=>'registratie.type.bibliotheek',
                            'museum'=>'registratie.type.museum',
                            'andere'=>'registratie.type.andere'
                        )),

                    'label' => 'Type van de organisatie' ))
            ->add('grootteOrganisatie', 'choice',
                    array(
                    'choices'=>(array(
                            '1'=>'1',
                            '2-5'=>'2-5',
                            '6-20'=>'6-20',
                            '21 of meer'=>'21 of meer'
                    )),
                    'label' => 'Grootte van de organisatie' ))
            ->add('taal', 'choice',
                array(
                  'choices'=>(array(
                           'nederlands'=>'nederlands',
                           'engels'=>'engels'
                  )),
                  'label' => 'taal' ));



    }


    public function getName()
    {
        return 'packed_user_registration';
    }
}
