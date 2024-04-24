<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Classification;
use App\Entity\Film;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('urlAffiche', TextType::class)
            ->add('lienTrailer', textType::class)
            ->add('resume', textType::class)
            ->add('duree', TimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateSortie', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'multiple' => true,
            ])
            ->add('classification', EntityType::class, [
                'class' => Classification::class,
                'choice_label' => 'intitule',
            ])
            ->add('Enregistrer', SubmitType::class, [
                'label' => 'Créer un film'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}
