<?php

namespace App\Controller;

use App\Entity\TrickPic;
use App\Entity\TrickVid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MediasController extends AbstractController
{
    /**
     * @Route("/trickpic/delete/{id}", name="deletePic")
     * @param TrickPic $trickPic
     * @return Response
     */
    public function deletePic(TrickPic $trickPic)
    {
        $user = $this->getUser();
        $trick = $trickPic->getTrick()->getName();

        if (!$user) { $this->redirectToRoute('home');}

        $currentFile = $trickPic->getPicName();
        $filesystem = new Filesystem();
        try {
            $filesystem->remove(
                $this->getParameter('upload_directory') . "/" . $currentFile
            );
        } catch (FileException $exception) {
            // mettre exception
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($trickPic);
        $manager->flush();

        $this->addFlash('deletePicSuccess', 'la photo a bien été supprimée');
        return $this->redirectToRoute('trickupdate', ['name' => $trick] );


    }

    /**
     * @Route("/trickvid/delete/{id}", name="deleteVid")
     * @param TrickVid $trickVid
     * @return RedirectResponse
     */
    public function deleteVid(TrickVid $trickVid)
    {
        $user = $this->getUser();
        $trick = $trickVid->getTrick()->getName();

        if (!$user) { $this->redirectToRoute('home');}

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($trickVid);
        $manager->flush();

        $this->addFlash('deleteVicSuccess', 'la vidéo a bien été supprimée');
        return $this->redirectToRoute('trickupdate', ['name' => $trick] );
    }

    // Just for testing the layout of emails

     /**
     * @Route("/firstemail/", name="firstEmail")
     * @return Response
     * @throws \Exception
     */
    public function firstMail()
    {
        $token = md5(random_bytes(10));
        return $this->render('email/email.html.twig', [
            'token' => $token,
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/changepassemail/", name="changepassemail")
     * @return Response
     * @throws \Exception
     */
    public function changePassEmail()
    {
        $token = md5(random_bytes(10));
        return $this->render('email/resetPassEmail.html.twig', [
            'token' => $token,
            'user' => $this->getUser()
        ]);
    }
}
