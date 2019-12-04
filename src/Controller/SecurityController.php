<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error, 'user' => null]);
    }

    /**
     * @Route("/logout", name="app_logout")
     * @throws Exception
     */
    public function logout()
    {
        throw new Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/checkit/{token}", name="token_check")
     * @param $token
     * @param ObjectManager $manager
     * @return RedirectResponse|Response
     */
    public function checkIt($token, ObjectManager $manager)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy(['token'=> $token]);

        if ($user) {
            $user->setToken(null);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('home');
        } else {
            return $this->render('security/check.html.twig', ['userNotFound' => true, 'user' => null]);

        }

    }
}
