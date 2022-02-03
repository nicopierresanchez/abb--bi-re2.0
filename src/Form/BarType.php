<?php

namespace App\Form;

use App\Entity\Bar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user')
            ->add('image')
            ->add('name')
            ->add('type')
            ->add('description')
            ->add('address')
            ->add('phone');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bar::class,
        ]);
    }
}
