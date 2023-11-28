<?php

namespace App\Form;

use App\Entity\Pays;
use App\Entity\Realisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RealisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom:',
                'attr' => [
                    'placeholder' => 'Veuillez saisir un nom...',
                ],
            ])
            ->add('nee', DateType::class, [
                'label' => 'Date de naissance:',
                'widget' => 'single_text',
            ])
            ->add('pays', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => 'nom',
                'attr' => [
                'placeholder' => 'Veuillez sélectionner une ville...',
            ]])
        ;
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Realisateur::class,
        ]);
    }
}
