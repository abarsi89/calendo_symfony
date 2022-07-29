<?php

namespace App\Form;

use App\Entity\Vendor;
use App\Entity\VendorAddress;
use App\Repository\VendorRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VendorAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('vendorAddressId')
            ->add('country')
            ->add('postalcode')
            ->add('city')
            ->add('address')
            ->add('isPrimary')
            ->add('isBilling')
//            ->add('vendor')
            ->add('vendor', EntityType::class, [
                'class' => Vendor::class,
                'query_builder' => function (VendorRepository $vendorRepository) {
                    return $vendorRepository->createQueryBuilder('v')
                        ->orderBy('v.name', 'ASC');
                },
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VendorAddress::class,
        ]);
    }
}
