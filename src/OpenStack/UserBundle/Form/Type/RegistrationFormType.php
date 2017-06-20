<?php

namespace OpenStack\UserBundle\Form\Type;

//use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use OpenStack\UserBundle\Form\Type\TelephoneType;

class RegistrationFormType extends BaseType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('nom', 'text', array('label'=>'Nom'))
                ->add('prenom', 'text', array('label'=>'Prénom'))
                ->add('dateNaissance', 'birthday', array('label'=>'Date de naissance', 'placeholder' => array('day' => 'Jour', 'month' => 'Mois', 'year' => 'Année')))   
                ->add('telephone', 'telephone', array('label'=>'Téléphone', 'max_length'=>15));
    }
    
    public function getName()
    {
        return 'openstack_user_registration';
    }

    /*public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'OpenStack\UserBundle\Entity\User',
        ]);
    }*/

}