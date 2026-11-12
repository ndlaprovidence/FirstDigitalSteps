<?php

namespace App\Controller;

use App\Entity\SlideShow;
use App\Form\SlideShowType;
use App\Repository\SlideShowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/slide/show')]
final class SlideShowController extends AbstractController
{
    #[Route(name: 'app_slide_show_index', methods: ['GET'])]
    public function index(SlideShowRepository $slideShowRepository): Response
    {
        return $this->render('slide_show/index.html.twig', [
            'slide_shows' => $slideShowRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_slide_show_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $slideShow = new SlideShow();
        $form = $this->createForm(SlideShowType::class, $slideShow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($slideShow);
            $entityManager->flush();

            return $this->redirectToRoute('app_slide_show_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('slide_show/new.html.twig', [
            'slide_show' => $slideShow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_slide_show_show', methods: ['GET'])]
    public function show(SlideShow $slideShow): Response
    {
        return $this->render('slide_show/show.html.twig', [
            'slide_show' => $slideShow,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_slide_show_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SlideShow $slideShow, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SlideShowType::class, $slideShow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_slide_show_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('slide_show/edit.html.twig', [
            'slide_show' => $slideShow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_slide_show_delete', methods: ['POST'])]
    public function delete(Request $request, SlideShow $slideShow, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$slideShow->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($slideShow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_slide_show_index', [], Response::HTTP_SEE_OTHER);
    }
}
