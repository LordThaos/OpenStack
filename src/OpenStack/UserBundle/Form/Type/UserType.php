<?php

namespace OpenStack\UserBundle\Form\Type;

use OpenStack\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*$builder
            ->add('email', 'email')
            ->add('username', 'text')
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
        ;*/
        
        $builder->add('username', 'text', array('label'=>"Nom d'utilisateur"))
                ->add('password', 'password', array('label'=>'Mot de passe'))
                ->add('confirm', 'password', array('mapped'=>false, 'label'=>'Confirmer le mot de passe'))
                ->add('nom', 'text', array('label'=>'Nom'))
                ->add('prenom', 'text', array('label'=>'Prénom'))
                ->add('dateNaissance', 'date', array('label'=>'Date de naissance'))
                ->add('email', 'email', array('label'=>'Adresse email'))
                ->add('telephone', 'integer', array('label'=>'Téléphone'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => User::class,));
    }

    public function getName()
    {
        return 'user';
    }
}