<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 08/08/2017
 * Time: 09:40
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_reza', DateType::class, array(
                'widget' => 'single_text',
                'label' => 'Date de visite'
            ))
            ->add('mail', EmailType::class, array(
                'label' => 'Adresse mail'
            ))
            ->add('billets', CollectionType::class, array(
                'entry_type' => BilletType::class,
                'allow_add' => true,
                'allow_delete' => true,
                // important poour collectionType
                'by_reference' => false,
                'label' => ' '
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Commande::class
        ));
    }
}
