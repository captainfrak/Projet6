<?php

namespace App\Controller;

use App\Entity\ProfilePic;
use App\Entity\User;
use App\Form\ResetPassType;
use App\Form\UploadType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/account/{username}", name="account")
     * @param Request $request
     * @param User $user
     * @return Response
     * @throws Exception
     */
    public function account(Request $request,User $user)
    {
        $profilePic = new ProfilePic();
        $form = $this->createForm(UploadType::class, $profilePic);
        $form->handleRequest($request);
        $manager = $this->getDoctrine()->getManager();

        if (!$user) { $this->redirectToRoute('home'); };

        if ($form->isSubmitted() && $form->isValid()) {
            $picFile = $form['photo']->getData();

            if ($picFile) {
                if ($user->getProfilePic() != null) {
                    $profilePic = $user->getProfilePic();
                    $filesystem = new Filesystem();

                    try {
                        $filesystem->remove(
                            $this->getParameter('upload_directory'). "/" . $profilePic->getName()
                            );
                    } catch (FileException $exception) {
                        echo "Problème lors de la suppression de l'ancienne image";
                    }
                    $profilePic->setName('');
                    $manager->persist($profilePic);
                    $manager->flush();
                }
                $fileName = md5(random_bytes(10)).'.'.$picFile->guessExtension();
                try {
                    $picFile->move(
                        $this->getParameter('upload_directory'),
                        $fileName
                    );
                } catch (FileException $exception) {
                    echo "Veuillez essayer à nouveau plus tard";
                    die();
                }

                $profilePic
                ->setName($fileName)
                ->setUser($user);

                $manager->persist($profilePic);
                $manager->flush();

                return $this->render(
                    'account/account.html.twig', [
                        'user' => $user,
                        'newPic' => true,
                        'success' => false,
                        'uploadForm' => $form->createView()
                    ]
                );
            }
        }
        return $this->render('account/account.html.twig', [
            'user' => $user,
            'success' => false,
            'newPic' => null,
            'uploadForm' => $form->createView()
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
