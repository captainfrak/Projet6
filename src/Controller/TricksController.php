<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\TrickPic;
use App\Entity\TrickVid;
use App\Form\CommentType;
use App\Form\TrickCreateUpdateType;
use App\Form\TrickPicFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
     * @param Request $request
     * @param Trick $trick
     * @param EntityManagerInterface $manager
     * @return Response
     * @throws Exception
     */
    public function singleTrick(Request $request,Trick $trick, EntityManagerInterface $manager)
    {
        $user = $this->getUser();

        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy(
            ['trick' => $trick->getId()],
            ['createdAt' => 'DESC']
        );
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new DateTime())
                    ->setTrick($trick)
                    ->setAuthor($user);

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('singletrick', ['name' => $trick->getName()]);
        }

        return $this->render('singletrick.html.twig',[
            'trick' => $trick,
            'user' => $user,
            'trickUpdate' => false,
            'comments' => $comments,
            'commentForm' => $form->createView()
        ]);

    }

    /**
     * @Route("/trickcreate", name="trickcreate")
     * @Route("/tricks/update/{name}", name="trickupdate")
     * @param Trick|null $trick
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function trickForm(Trick $trick = null, Request $request)
    {
        $user = $this->getUser();
        $manager = $this->getDoctrine()->getManager();

        if (!$user) { return $this->redirectToRoute('home');}

        if (!$trick) {
            $trick = new Trick();
        }
        $trickPic = new TrickPic();
        $trickVid = new TrickVid();

        $form = $this->createForm(TrickCreateUpdateType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('picName')->getData() != null) {

                $picFile = $form['picName']->getData();

                $fileName = md5(random_bytes(10)).'.'.$picFile->guessExtension();
                try {
                    $picFile->move(
                        $this->getParameter('upload_directory'),
                        $fileName
                    );
                } catch (FileException $exception) {
                    //mettre exception
                }

                $trickPic
                    ->setPicName($fileName)
                    ->setTrick($trick);
                $manager->persist($trickPic);
            }
            if ($form->get('trickVid')->getData() != null) {
                $trickVid
                    ->setUrl($form->get('trickVid')->getData())
                    ->setTrick($trick);
                $manager->persist($trickVid);
            }
            $currentGroup = $form->get('trickGroup')->getData();
            $currentCategory = $currentGroup->getCategory();
            if ($trick->getFigureGroup() != null) {
                $currentCategory = $trick->getFigureGroup();
            }
            $trick
                ->setFigureGroup($currentCategory)
                ->setCreatedAt(new DateTime())
                ->setAuthor($user);

            $manager->persist($trick);
            $manager->flush();

            return $this->redirectToRoute('singletrick', [
                'name' => $trick->getName(),
                'user' => $user,
            ]);
        }
        return $this->render('trickcreate.html.twig', [
            'trickForm' => $form->createView(),
            'update' => $trick->getId() !== null,
            'user' => $user,
            'trick' => $trick
        ]);
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
                'deleteComplete' => true,
                'trickUpdate' => false
            ]);
        }
    }
}