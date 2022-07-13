<?php

namespace App\Form;

use App\Entity\VendorAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VendorAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('vendorAddressId')
            ->add('country')
            ->add('postalcode')
            ->add('city')
            ->add('address')
            ->add('isPrimary')
            ->add('isBilling')
            ->add('vendor')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VendorAddress::class,
        ]);
    }
}
