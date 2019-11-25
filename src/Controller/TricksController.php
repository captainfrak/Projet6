<?php

namespace App\Controller;

use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{
    /**
     * @Route("/tricks", name="tricklist")
     */
    public function trickList()
    {
        $tricks = $this->getDoctrine()->getRepository(Trick::class)->findBy([],['createdAt' => 'DESC']);
        $user = $this->getUser();

        dump($user);
        return $this->render('trickList.html.twig', [
            'user' => $user,
            'tricks' => $tricks
        ]);
    }

    /**
     * @Route("/trickcreate", name="trickcreate")
     */
    public function trickCreate()
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('home');
        } else {
            $trick = new Trick();
            return $this->render('trickcreate.html.twig');
        }

    }

}