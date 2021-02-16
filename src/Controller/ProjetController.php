<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Repository\ProjetsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjetController extends AbstractController
{
    /**
     * @Route("/admin/projets", name="admin_projets")
     */
    public function index(ProjetsRepository $projetsRepository): Response
    {
        $projets = $projetsRepository->findAll();
        return $this->render('admin/projet.html.twig', [
            'projets' => $projets,
        ]);
    }
}
