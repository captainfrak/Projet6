<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    /**
    * @Route("/", name="home")
    */
    public function index()
    {
        $user = $this->getUser();
        return $this->render('index.html.twig', [
            'user' => $user
        ]);
    }

}
