<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('auteur', EntityType::class, [
                'class' => Auteur::class,
                'label' => 'Auteur:',
                'multiple' => false,
                'choice_label' => 'nom',
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'label' => 'Categories:',
                'multiple' => true,
                'choice_label' => 'nom',
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
