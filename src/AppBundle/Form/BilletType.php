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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomClient', TextType::class, array(
                'label' => 'Nom'
            ))
            ->add('prenomClient', TextType::class, array(
                'label' => 'Prénom'
            ))
            ->add('pays', TextType::class, array(
                'label' => 'Pays'
            ))
            ->add('dateNaissance', DateType::class, array(
                'label' => 'Date de naissance'
            ))
            ->add('mail', EmailType::class, array(
                'label' => 'Adresse mail'
            ))
            ->add('typeBillet', ChoiceType::class, array(
                'choices' => array(
                    'Journée' => 1,
                    'Demi-journée' => 2
                ),
                'label' => 'Type de billet'
            ))
            ->add('tarifReduit', CheckboxType::class, array(
                'label' => 'Tarif réduit',
                'required' => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Billet::class,
        ));
    }

}