<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Genre;
use App\Entity\Pays;
use App\Entity\Realisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;



class FilmType extends AbstractType
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

            ->add('date_de_sortie', DateType::class, [
                'label' => 'Date de sortie:',
                'widget' => 'single_text',
            ])

            ->add('realisateur', EntityType::class, [
                'label' => 'Réalisateur(s):',
                'class' => Realisateur::class,
                'multiple' => true,
                'expanded' => false,
            ])

            ->add('genre', EntityType::class, [
                'label' => 'Genre(s):',
                'class' => Genre::class,
                'multiple' => true,
                'expanded' => false,
            ])

            ->add('duree', TimeType::class, [
                'label' => 'Durée:',
                'widget' => 'single_text'
            ])

            ->add('synopsis', TextType::class, [
                'label' => 'Synopsis:',
                'attr' => [
                    'placeholder' => 'Veuillez saisir un résumé...',
                ]
            ])

            ->add('bande_annonce', UrlType::class, [
                'label' => 'Bande-annonce:',
                'attr' => [
                    'placeholder' => 'Veuillez saisir une bande annonce...',
                ]
            ])

            ->add('avertissement', ChoiceType::class, [
                'label' => 'Avertissement:',
                'choices' => [
                    'Aucun avertissement' => 'Aucun avertissement',
                    'Accord Parental' => 'Accord Parental',
                    '-10' => '-10ans',
                    '-12' => '-12',
                    '-16' => '-16',
                    '-18' => '-18',
                ],
                'multiple' => false,
                'expanded' => false,
            ])

            ->add('noteSpectateur', ChoiceType::class, [
                'choices' => [
                    '0' => '0',
                    '0.5' => '0.5',
                    '1' => '1',
                    '1.5' => '1.5',
                    '2' => '2',
                    '2.5' => '2.5',
                    '3' => '3',
                    '3.5' => '3.5',
                    '4' => '4',
                    '4.5' => '4.5',
                    '5' => '5',
                ],
                'label' => 'Note spectateur:',
                'multiple' => false,
            ])

            ->add('note', ChoiceType::class, [
                'choices' => [
                    '0' => '0',
                    '0.5' => '0.5',
                    '1' => '1',
                    '1.5' => '1.5',
                    '2' => '2',
                    '2.5' => '2.5',
                    '3' => '3',
                    '3.5' => '3.5',
                    '4' => '4',
                    '4.5' => '4.5',
                    '5' => '5',
                ],
                'label' => 'Ma note:',
                'multiple' => false,
            ])

            ->add('vu', ChoiceType::class, [
                'label' => 'Déja vu ?',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'multiple' => false,
                'expanded' => false,
                ])

            ->add('favoris', ChoiceType::class, [
                'label' => 'Favoris ?',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'multiple' => false,
                'expanded' => false,
            ])

            ->add('jaquette', FileType::class, [
                'attr' => [
                    'placeholder' => 'Sélectionner une jaquette:',
                    'autocomplete' => 'jaquette',
                ],
                'label' => 'Sélectionner une jaquette au format: jpeg, jpg, png',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1000000',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez sélectionner un format de type: jpeg, jpg, png !',
                    ]),
                ],
            ])

            ->add('wallpaper', FileType::class, [
                'attr' => [
                    'placeholder' => 'Sélectionner un wallpaper:',
                    'autocomplete' => 'wallpaper',
                ],
                'label' => 'Sélectionner un wallpaper au format: jpeg, jpg, png',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1000000',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez sélectionner un format de type: jpeg, jpg, png !',
                    ]),
                ],
            ])


            /*->add('wallpaper', FileType::class, [
                'attr' => [
                    'autocomplete' => 'picture',
                ],
                'label' => 'Sélectionner un poster:',
                'mapped' => false,
                'required' => false,
                'constraints' => []])

            ->add('photo', FileType::class, [
                'attr' => [
                    'autocomplete' => 'picture',
                ],
                'label' => 'Sélectionner une ou plusieurs photo(s):',
                'mapped' => false,
                'required' => false,
                'constraints' => []])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}
