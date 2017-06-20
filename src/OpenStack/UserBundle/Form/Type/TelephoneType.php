<?php

namespace OpenStack\UserBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
 
class TelephoneType extends AbstractType
{
    public function getName()
    {
        return 'telephone';
    }
 
    
    public function getParent()
    {
        return 'text';
    }
}

?>
