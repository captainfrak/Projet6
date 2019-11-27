<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickCreateUpdateType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

        return $this->render('trickList.html.twig', [
            'user' => $user,
            'tricks' => $tricks,
            'deleteComplete' => false,
            'trickUpdate' => false
        ]);
    }

    /**
     * @Route("tricks/{name}", name="singletrick")
     * @param $name
     * @return Response
     */
    public function singleTrick($name)
    {
        $trick = $this->getDoctrine()->getRepository(Trick::class)->findOneBy(['name' => $name]);
        $user = $this->getUser();


        return $this->render('singletrick.html.twig',[
            'trick' => $trick,
            'user' => $user,
            'trickUpdate' => false
        ]);

    }

    /**
     * @Route("/trickcreate", name="trickcreate")
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function trickCreate(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(TrickCreateUpdateType::class);
        $form->handleRequest($request);

        if (!$user) {
            return $this->redirectToRoute('home');
        } else {
            $trick = new Trick();

            if ($form->isSubmitted() && $form->isValid()) {
                $name = $form->get('name')->getData();
                $description = $form->get('description')->getData();
                $figureGroup = $form->get('figureGroup')->getData();
                $trick
                    ->setName($name)
                    ->setDescription($description)
                    ->setFigureGroup($figureGroup)
                    ->setCreatedAt(new \DateTime());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($trick);
                $entityManager->flush();

                return $this->render('trickcreate.html.twig', [
                    'user' => $user,
                    'trickForm' => $form->createView(),
                    'success' => $trick
                ]);
            }

            return $this->render('trickcreate.html.twig', [
                'user' => $user,
                'trickForm' => $form->createView(),
                'success' => false,
                'update' => false
            ]);
        }

    }

    /**
     * @Route("/tricks/update/{name}", name="trickupdate")
     * @param $name
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function trickUpdate($name, Request $request)
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('home');
        } else {
            $form = $this->createForm(TrickCreateUpdateType::class);
            $form->handleRequest($request);
            $trick = $this->getDoctrine()->getRepository(Trick::class)->findOneBy(['name' => $name]);

            if ($form->isSubmitted() && $form->isValid()) {
                $modifName = $form->get('name')->getData();
                $newName = $modifName;
                $description = $form->get('description')->getData();
                $figureGroup = $form->get('figureGroup')->getData();
                $trick
                    ->setName($modifName)
                    ->setDescription($description)
                    ->setFigureGroup($figureGroup)
                    ->setCreatedAt(new \DateTime());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($trick);
                $entityManager->flush();

                $tricks = $this->getDoctrine()->getRepository(Trick::class)->findBy([],['createdAt' => 'DESC']);


                return $this->render('trickList.html.twig', [
                    'trick' => $newName,
                    'user' => $user,
                    'trickUpdate' => true,
                    'tricks' => $tricks,
                    'deleteComplete' => false
                ]);
            } else {
                return $this->render('trickcreate.html.twig', [
                    'user' => $user,
                    'trickForm' => $form->createView(),
                    'success' => false,
                    'trick' => $trick,
                    'update' => true
                ]);
            }
        }



    }

    /**
     * @Route("/tricks/delete/{name}", name="trickdelete")
     * @param $name
     * @return Response
     */
    public function trickDelete($name)
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('home');
        } else {
            $trick = $this->getDoctrine()->getRepository(Trick::class)->findOneBy(['name' => $name]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trick);
            $entityManager->flush();

            $tricks = $this->getDoctrine()->getRepository(Trick::class)->findBy([],['createdAt' => 'DESC']);

            return $this->render('trickList.html.twig', [
                'user' => $user,
                'tricks' => $tricks,
                'deleteComplete' => true
            ]);
        }
    }
}