<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Quack;
use App\Form\CommentsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentsController extends AbstractController
{

    #[Route('/quack/{id}/comments', name: 'app_comments')]
    public function index(Request $request, EntityManagerInterface $entityManager, Quack $quack): Response
    {

        $comment = new Comments($quack);
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_comments', ['id' => $quack->getId()]);
        }

        return $this->render('comments/show.html.twig', [
            "quack" => $quack,
            'formComment' => $form->createView(),


        ]);
    }
}