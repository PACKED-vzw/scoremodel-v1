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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraint\UserPassword;

use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
        ->add('organisatie')
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

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention'  => 'profile',
        ));
    }

    public function getName()
    {
        return 'packed_user_profile';
    }

    /**
     * Builds the embedded form representing the user.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
   /* protected function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
            ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('organisatie')
        ;
    }    */
}
