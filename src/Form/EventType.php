<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Service;
use App\Entity\VendorAddress;
use App\Repository\ServiceRepository;
use App\Repository\VendorAddressRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        dd($options);
        $builder
//            ->add('vendorId', HiddenType::class, [
//                'data' => print_r(json_encode($options)),
//            ])
//            ->add('eventId')
            ->add('date', DateType::class)
//            ->add('service', ChoiceType::class)
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'query_builder' => function (ServiceRepository $serviceRepository) {
                    return $serviceRepository->createQueryBuilder('s')
                        ->where("s.vendorId = '".$_SESSION['_sf2_attributes']['vendorId']."' AND s.deletedAt IS NULL")
                        ->groupBy('s.typeId')
                        ->orderBy('s.name', 'ASC');
                },
                'choice_label' => 'name',
            ])
            ->add('address', EntityType::class, [
                'class' => VendorAddress::class,
                'query_builder' => function (VendorAddressRepository $vendorAddressRepository) {
                    return $vendorAddressRepository->createQueryBuilder('va')
                        ->where("va.vendor = '".$_SESSION['_sf2_attributes']['vendorId']."'")
                        ->orderBy('va.address', 'ASC');
                },
                'choice_label' => function ($vendorAddress) {
                    return $vendorAddress->getFullAddress();
                },
            ])
        ;
        if ($options['is_customer_email_needed']) {
            $builder->add('customerEmail', EmailType::class);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
            'is_customer_email_needed' => false
        ]);

        $resolver->setAllowedTypes('is_customer_email_needed', 'bool');
    }
}
