<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StartController extends AbstractController
{
    #[Route('/start', name: 'app_start', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $pseudo = trim($request->request->getString('pseudo'));

            if ($pseudo !== '') {
                $request->getSession()->set('player_pseudo', $pseudo);

                return $this->redirectToRoute('app_theme_index');
            }
        }

        return $this->render('start/index.html.twig');
    }
}
