<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Acteur;
use App\Entity\City;
use App\Entity\Food;
use App\Entity\Genre;
use App\Entity\Pays;
use App\Entity\Realisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('genre', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Genre::class,
                'placeholder' => 'Genre (tous)',
            ])

            ->add('realisateur', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Realisateur::class,
                'placeholder' => 'Réalisateur (tous)',
            ])

            ->add('acteur', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Acteur::class,
                'placeholder' => 'Acteur (tous)',
            ])

            ->add('annee', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Realisateur::class,
                'placeholder' => 'Réalisateur (tous)',
            ])

            ->add('note', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Realisateur::class,
                'placeholder' => 'Réalisateur (tous)',
            ])

            ->add('save', SubmitType::class, [
                'label' => 'Trier',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
