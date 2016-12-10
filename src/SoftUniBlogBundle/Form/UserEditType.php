<?php
/**
 * Created by PhpStorm.
 * User: Danny
 * Date: 10.12.2016 г.
 * Time: 11:30
 */

namespace SoftUniBlogBundle\Form;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Test\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sensio\Bundle\FrameworkExtraBundle\Request;




class UserEditType extends UserType
{
public function configureOptions(OptionsResolver $resolver)
{
   $resolver->setDefaults(array(
       'data_class'=>'SoftUniBlogBundle\Entity\User'
   ));
}

public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder,array $options)
{
    parent::buildForm($builder,$options);
    $builder->add('roles',ChoiceType::class,array(
        'choices'=>[
            'Admin'=>"ROLE_ADMIN",
            'User'=>"ROLE_USER",
        ],
        'expanded'=>true,
        'multiple'=>true,

    ));
}


}