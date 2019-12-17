<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PassAskEmailType;
use App\Form\ResetPassType;
use Exception;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PassChangeController extends AbstractController
{
    /**
     * @Route("/pass/change", name="pass_change")
     * @param Request $request
     * @param Swift_Mailer $mailer
     * @return Response
     * @throws Exception
     */
    public function typeEmail(Request $request, Swift_Mailer $mailer)
    {
        $form = $this->createForm(PassAskEmailType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository(User::class);
            $email = $form->getData();
            $user = $repo->findOneBy(['email'=> $email]);
            $random = random_bytes(10);
            $token = md5($random);

            $user->setToken($token);
            $em->persist($user);
            $em->flush();

            $email = (new Swift_Message())
                ->setFrom('hello@example.com')
                ->setTo('you@example.com')
                ->setSubject('Changement du mot de passe')
                ->setBody($this->renderView('email/resetPassEmail.html.twig', ['token' => $token]), 'text/html');

            $mailer->send($email);

            //TODO add field in homepage to say that email has been send + change the render beside!
            return $this->render('/pass_change/emailask.html.twig', [
                'askEmailForm' => $form->createView()
            ]);
        }

        return $this->render('/pass_change/emailask.html.twig', [
            'askEmailForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("pass/reset/{token}", name="reset_password")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param $token
     * @return Response
     */
    public function resetPassword(Request $request,UserPasswordEncoderInterface $passwordEncoder, $token)
    {
        $form = $this->createForm(ResetPassType::class);
        $form->handleRequest($request);

        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy(['token'=> $token]);

        if ($user) {
            if ($form->isSubmitted() && $form->isValid()) {
                //TODO Ajout second champ email pour vérif en le tapant 2fois
                $user->setToken(null);

                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->render('pass_change/resetPassword.html.twig', [
                    'resetForm' => $form->createView(),
                    'errorChange' => false,
                    'resetSucces' => true
                ]);
            }
        } else {
            return $this->render('pass_change/resetPassword.html.twig', [
                'errorChange' => true,
                'resetSucces' => false,
                'resetForm' => $form->createView()
            ]);
        }
        dump($user);
        return $this->render('pass_change/resetPassword.html.twig', [
            'errorChange' => false,
            'resetSucces' => false,
            'resetForm' => $form->createView()
        ]);
    }

}

