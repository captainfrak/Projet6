<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPassType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/account/{username}", name="account")
     * @param User $user
     * @return Response
     */
    public function account(User $user)
    {
        if (!$user) { $this->redirectToRoute('home'); };


        return $this->render('account/account.html.twig', [
            'user' => $user,
            'success' => false
        ]);
    }

    /**
     * @Route("/account/passchange/{username}", name="passAccount")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param User $user
     * @return Response
     */
    public function accountPassChange(Request $request, UserPasswordEncoderInterface $passwordEncoder,User $user)
    {
        $form = $this->createForm(ResetPassType::class);
        $form->handleRequest($request);
        $currentUser = $this->getUser();

        $pass1 = $form->get('password')->getData();
        $pass2 = $form->get('password2')->getData();

        if ($user !== $currentUser) { return $this->redirectToRoute('home'); };

        if ($form->isSubmitted() && $form->isValid()) {
            if ($pass1 === $pass2) {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->render('account/account.html.twig', [
                    'success' => true,
                    'user' => $user
                ]);
            }
            return $this->render('account/accountPass.html.twig',[
                'user' => $user,
                'passChange' => $form->createView(),
                'checkAgain' => true
            ]);
        }
        return $this->render('account/accountPass.html.twig',[
            'user' => $user,
            'passChange' => $form->createView(),
            'checkAgain' => false
        ]);
    }
}
