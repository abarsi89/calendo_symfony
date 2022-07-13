<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
//    public function __construct()
//    {
//        $this->r
//    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('roles', ChoiceType::class, [
                'mapped' => false,
                'choices'  => [
                    'Customer' => 'CUSTOMER',
                    'Admin' => 'ADMIN',
                    'Superadmin' => 'SUPERADMIN',
                ],
            ])
//            ->add('roles', ChoiceType::class, [
////                'choice_loader' => new CallbackChoiceLoader(function() {
//////                    return StaticClass::getConstants();
////                    return RoleRepository::getAllRoles();
////                }),
////                'choices'  => $this->getAllRoles(),
//            ])
//            ->add('roles', EntityType::class, [
//                'class' => Role::class,
////                'query_builder' => function (EntityRepository $er) {
////                    return $er->createQueryBuilder('r')
////                        ->orderBy('r.name', 'ASC');
////                },
//                'choice_label' => 'name',
//            ])
//            ->add('roles', EnumType::class, [
//                'class' => Role::class,
//            ])
        ;

//        $builder->get('roles')
//            ->addModelTransformer(new CallbackTransformer(
//                function ($rolesArray) {
//                    // transform the array to a string
//                    return count($rolesArray)? $rolesArray[0]: null;
//                },
//                function ($rolesString) {
//                    // transform the string back to an array
//                    return [$rolesString];
//                }
//            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    private function getAllRoles()
    {
        global $kernel;

//        if ( 'AppCache' == get_class($kernel) ) {
//            $kernel = $kernel->getKernel();
//        }
        $doctrine = $kernel->getContainer()->get('doctrine');

        $roleRepository = $doctrine->getRepository('Role');
        $roles = $roleRepository->findAll();
        dd($roles);
    }
}
