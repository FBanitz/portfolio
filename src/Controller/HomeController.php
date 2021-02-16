<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProjetsRepository $projetsRepository): Response
    {
        $projets = $projetsRepository->findAll();
        
        return $this->render('home/index.html.twig', [
            'projets' => $projets,
        ]);
    }
}
