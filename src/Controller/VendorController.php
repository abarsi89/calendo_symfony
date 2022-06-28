<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\Vendor;
use App\Form\RegistrationType;
use App\Form\VendorType;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Repository\VendorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class VendorController extends AbstractController
{
    public function index(VendorRepository $vendorRepository): Response
    {
        return $this->render('vendor/index.html.twig', [
            'vendors' => $vendorRepository->findAll(),
        ]);
    }

    public function new(Request $request, VendorRepository $vendorRepository, UserRepository $userRepository, RoleRepository $roleRepository , UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $vendor = new Vendor();
        $vendor->setVendorId(Uuid::v4());
        $vendor->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(VendorType::class, $vendor);
        $form->handleRequest($request);

        $user = new User();
        $form2 = $this->createForm(RegistrationType::class, $user);
        $form2->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vendorRepository->add($vendor, true);

            $userData = $form2->getData();

//            $user = new User();
            $user->setUserId(Uuid::v4());
            $user->setEmail($userData->getEmail());
            $user->setName($userData->getName());
            $user->setCreatedAt(new \DateTimeImmutable());

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form2->get('plainPassword')->getData()
                )
            );

            $userRepository->add($user, true);

            $user->addRole($roleRepository->findOneBy(['name' => Role::ROLE_ADMIN]));
            $user->addVendor($vendor);
            $userRepository->add($user, true);

            return $this->redirectToRoute('vendor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vendor/new.html.twig', [
            'vendor' => $vendor,
            'form' => $form,
            'form2' => $form2,
        ]);
    }

    public function show(Vendor $vendor): Response
    {
        return $this->render('vendor/show.html.twig', [
            'vendor' => $vendor,
        ]);
    }

    public function edit(Request $request, Vendor $vendor, VendorRepository $vendorRepository): Response
    {
        $form = $this->createForm(VendorType::class, $vendor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vendorRepository->add($vendor, true);

            return $this->redirectToRoute('vendor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vendor/edit.html.twig', [
            'vendor' => $vendor,
            'form' => $form,
        ]);
    }

    public function delete(Request $request, Vendor $vendor, VendorRepository $vendorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vendor->getVendorId(), $request->request->get('_token'))) {
            $vendorRepository->remove($vendor, true);
        }

        return $this->redirectToRoute('vendor_index', [], Response::HTTP_SEE_OTHER);
    }
}
