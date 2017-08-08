<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 08/08/2017
 * Time: 09:40
 */

namespace AppBundle\Form;

use AppBundle\Entity\Billet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateReza', DateType::class)
            ->add('typeBillet', ChoiceType::class, array(
                'choices' => array(
                    'Journée' => 1,
                    'Demi-journée' => 2,
                ),
            ))
            ->add('quantite', ChoiceType::class, array(
                'choices' => array(
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Billet::class,
        ));
    }

}