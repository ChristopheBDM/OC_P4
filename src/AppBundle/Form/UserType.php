<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 08/08/2017
 * Time: 11:48
 */

namespace AppBundle\Form;

use AppBundle\Entity\Billet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomClient', TextType::class, array(
                'label' => 'Nom',
            ))
            ->add('prenomClient', TextType::class)
            ->add('pays', TextType::class)
            ->add('dateNaissance', DateType::class)
            ->add('mail', EmailType::class)
            ->add('tarifReduit', CheckboxType::class, array(
                'label' => 'Tarif réduit',
                'required' => false,
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Billet::class,
        ));
    }

}