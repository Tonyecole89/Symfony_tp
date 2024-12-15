<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Professeur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // pour le formulaire 
        $builder
            ->add('title')
            ->add('description')
            ->add('professeur', EntityType::class, [
                'class' => Professeur::class,
                'choice_label' => 'name', 
                'placeholder' => 'Sélectionnez un professeur', 
                'required' => false,    
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
