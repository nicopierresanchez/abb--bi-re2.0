<?php

namespace App\Form;

use App\Entity\Bar;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientBarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',null, array('label' => 'Nom'))
            ->add('type')
            ->add('address',null, array('label' => 'Adresse'))
            ->add('description')
            ->add('phone',null, array('label' => 'Telephone'))
            ->add('image');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bar::class,
        ]);
    }
}
