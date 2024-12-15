<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la catégorie',
            ])
            // Si le slug est généré automatiquement, on peut commenter ou retirer cette ligne
            // ->add('slug', TextType::class, [
            //     'label' => 'Slug (laisser vide pour une génération automatique)',
            // ])
            ->add('parent', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name', // On affiche le nom des catégories au lieu des ID
                'label' => 'Catégorie parente',
                'placeholder' => 'Aucune', // Option pour ne pas choisir de parent
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer la catégorie',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
