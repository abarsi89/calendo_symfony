<?php

namespace App\Controller;

use App\Entity\Login;
use App\Entity\Register;
use App\Entity\User;
use App\Form\Type\RegisterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class RegisterController extends AbstractController
{
    public function index(ManagerRegistry $doctrine, Request $request = null): Response
    {
        phpinfo();
        $form = $this->createForm(RegisterType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $data = $form->getData();

            // ... perform some action, such as saving the task to the database
            $repository = $doctrine->getRepository(Register::class);
            if ($repository->checkEmail($data['email'])) {
                $newUser = $this->register($doctrine, $data);

                return $this->render('register/success.html.twig', [
                    'user' => $newUser,
                ]);
            }
        }

        return $this->renderForm('register/index.html.twig', [
            'form' => $form,
        ]);
    }

    private function register($doctrine, $data): User
    {
        $entityManager = $doctrine->getManager();

        $user = new User();
        $user->setId(Uuid::v4());
        $user->setEmail($data['email']);
        $user->setName($data['name']);
        $user->setCreatedAt(new \DateTimeImmutable());

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

//        var_dump($user);die();

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $registration = new Login();
        $registration->setId(Uuid::v4());
        $registration->setUserId($user->getId());

        $password = password_hash($data['password'], Login::HASH_ALGORITHM);
        $registration->setPassword($password);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($registration);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $user;
    }
}
