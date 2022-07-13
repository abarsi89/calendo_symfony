<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\Vendor;
use App\Form\RegistrationType;
use App\Form\UserType;
use App\Form\VendorType;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Repository\VendorRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class UserController extends AbstractController
{

    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    public function new(Request $request, UserRepository $userRepository, RoleRepository $roleRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $user->setUserId(Uuid::v4());
            $user->setEmail($data->getEmail());
            $user->setName($data->getName());
            $user->setCreatedAt(new \DateTimeImmutable());

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $userRepository->add($user, true);

            $user->addRole($roleRepository->findOneBy(['name' => Role::ROLE_ADMIN]));
            $userRepository->add($user, true);

            return $this->redirectToRoute('vendor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vendor/new.html.twig', [
            'vendor' => $user,
            'form' => $form,
        ]);
    }

    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    public function edit(Request $request, User $user, UserRepository $userRepository, RoleRepository $roleRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $oldRole = current($user->getRoles());
            $newRole = $request->request->get('user')['role'];
            if($oldRole) {
                $user->removeRole($oldRole);
            }
            if ($oldRole != $newRole) {
                $user->addRole($roleRepository->findOneBy(['name' => $newRole]));
            }

            $userRepository->add($user, true);

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getUserId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}
