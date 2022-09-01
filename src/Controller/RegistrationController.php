<?php

namespace App\Controller;

use App\Entity\Login;
use App\Entity\Role;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Uid\Uuid;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository, RoleRepository $roleRepository, LoginFormAuthenticator $loginAuthenticator, GuardAuthenticatorHandler $guard): Response
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
            $login = new Login();
            $login->setUserId($user->getUserId());
            $login->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->persist($login);
            $entityManager->flush();

            $user->addRole($roleRepository->findOneBy(['name' => Role::ROLE_CUSTOMER]));
            $userRepository->add($user, true);

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('email_verification', $user,
                (new TemplatedEmail())
                    ->from(new Address('noreply@calendo.hu', 'Calendo'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

//            return $this->redirectToRoute('user_show', ['id' => $user->getId()]);

            $this->addFlash('success', 'The registration is successfull');
            //This is how the User could be logged after the registration
            //Guard handle it
            //'main' is your main Firewall. You can check it in config/packages/security.yaml
            return $guard->authenticateUserAndHandleSuccess($user, $request, $loginAuthenticator, 'main');

        }



        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    public function verifyUserEmail(Request $request, UserRepository $userRepository): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('registration');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('registration');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('registration');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('registration');
    }
}
