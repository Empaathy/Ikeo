<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'placeholder' => 'Tapez le nom du produit',
            ])
            ->add('price', FloatType::class, [
                'label' => 'Prix',
                'palceholder' => 'Tapez le prix du produit en €'
            ])
            ->add('poster', TextType::class, [
                'label' => 'Lien de l\'image',
            ])
            ->add('short_desc', CKEditorType::class, [
                'label' => 'Courte description',
                'placeholder' => 'Tapez une description courte mais parlante pour le visiteur',
                'config_name' => 'light',
                'attr' => ['rows' => '4'],
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'placeholder' => '-- Choisir une catégorie --',
                'class' => Category::class,
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
