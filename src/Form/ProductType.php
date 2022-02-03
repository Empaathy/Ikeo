<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Tapez le nom du produit',

                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'attr' => [
                    'placeholder' => 'Tapez le prix du produit en €'
                ]
            ])
            ->add('poster', TextType::class, [
                'label' => 'Lien de l\'image',
            ])
            ->add('short_desc', TextareaType::class, [
                'label' => 'Courte description',
                'attr' => [
                    'rows' => '4',
                    'placeholder' => 'Tapez une description courte mais parlante pour le visiteur',
                ],
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'attr' => [
                    'placeholder' => '-- Choisir une catégorie --',

                ],
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
