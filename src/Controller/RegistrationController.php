<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Exception;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Swift_Mailer $mailer
     * @return Response
     * @throws Exception
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, Swift_Mailer $mailer): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        $pass1 = $form->get('plainPassword')->getData();
        $pass2 = $form->get('plainPassword2')->getData();

        $random = random_bytes(10);
        $token = md5($random);


        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            if ($pass2 === $pass1) {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $user->setToken($token);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                // do anything else you need here, like send an email
                $email = (new Swift_Message())
                    ->setFrom('hello@snowtricks.com')
                    ->setTo($user->getEmail())
                    ->setSubject('Confirmation d\'inscription')
                    ->setBody(
                        $this->renderView(
                            'email/email.html.twig',
                            [
                                'token' => $token,
                                'user' => $user
                            ]
                        ),
                        'text/html'
                    );

                $mailer->send($email);

                return $this->redirectToRoute('home');
            }
            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form->createView(),
                'user' => false,
                'notTheSame' => true
            ]);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'user' => false,
            'notTheSame' => false
        ]);
    }
}
