<?php

namespace App\Controller;

use App\Entity\Login;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function index(): Response
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    public function register(ManagerRegistry $doctrine, Request $request): Response
    {
        var_dump($request);die();
        $entityManager = $doctrine->getManager();

        $user = new User();
        $user->setEmail('admin2@calendo.hu');
        $user->setName('Admin2');
        $user->setCreatedAt(new \DateTimeImmutable());

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $registration = new Login();
        $registration->setUserId($user->getId());

        $password = password_hash('ssdfsd', Login::HASH_ALGORITHM);
        $registration->setPassword($password);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($registration);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new registration with id '.$registration->getId());
    }
}
