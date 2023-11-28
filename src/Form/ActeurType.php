<?php

namespace App\Form;

use App\Entity\Acteur;
use App\Entity\Pays;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom:',
                'attr' => [
                    'placeholder' => 'Veuillez saisir un acteur...',
                ],
            ])
            ->add('pays', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => 'nom',
                'attr' => [
                    'placeholder' => 'Veuillez sélectionner une ville...',
                ]])        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Acteur::class,
        ]);
    }
}
