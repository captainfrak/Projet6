<?php

namespace App\Controller;

use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    /**
    * @Route("/", name="home")
    */
    public function index()
    {
        $tricks = $this->getDoctrine()->getRepository(Trick::class)->findBy([],['createdAt' => 'DESC']);
        $user = $this->getUser();
        return $this->render('index.html.twig', [
            'user' => $user,
            'tricks' => $tricks
        ]);
    }

}
