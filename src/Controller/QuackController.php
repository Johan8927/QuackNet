<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Entity\UserSecurity;
use App\Form\QuackType;
use App\Repository\QuackRepository;
use App\Security\Voter\DuckVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/quack')]
final class QuackController extends AbstractController
{
    #[Route(name: 'app_quack_index', methods: ['GET'])]
    public function index(QuackRepository $quackRepository): Response
    {
        return $this->render('quack/index.html.twig', [
            'quacks' => $quackRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_quack_new', methods: ['GET', 'POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $quack = new Quack();
        $form = $this->createForm(QuackType::class, $quack);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $quack->setAuthor($this->getUser());
            $entityManager->persist($quack,);
            $entityManager->flush();
            $this->addFlash('success', 'Quack created successfully.');
            return $this->redirectToRoute('app_quack_show', ['id' => $quack->getId()], Response::HTTP_SEE_OTHER);
        }


        return $this->render('quack/new.html.twig', [
            'quack' => $quack,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quack_show', methods: ['GET'])]
    public function show(Quack $quack): Response
    {
        return $this->render('quack/show.html.twig', [
            'quack' => $quack,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_quack_edit', methods: ['GET', 'POST'])]
    #[IsGranted(DuckVoter::EDIT, subject: 'quack')]
    public function edit(Request $request, Quack $quack, EntityManagerInterface $entityManager): Response
    {

        // si author n'est pas connecté
        /*
        if (!$this->getUser() || $quack->getAuthor()->getId()!== $this->getUser()->getId()) {
            throw $this->createAccessDeniedException('You cannot edit this quack.');
        }
        if (!$this->isGranted(DuckVoter::EDIT, $quack)) {
            throw $this->createAccessDeniedException('You cannot edit this quack.');
        }
        */

        $form = $this->createForm(QuackType::class, $quack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Quack updated successfully.');
            return $this->redirectToRoute('app_quack_show', ['id' => $quack->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quack/edit.html.twig', [
            'quack' => $quack,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quack_delete', methods: ['POST'])]
    #[IsGranted(DuckVoter::DELETE, subject: 'quack')]
    public function delete(Request $request, Quack $quack, EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete' . $quack->getId(), $request->request->get('_token'))) {
            $entityManager->remove($quack);
            $entityManager->flush();
            $this->addFlash('success', 'Quack deleted successfully.');
        }
        return $this->redirectToRoute('app_quack_index');
    }
}