<?php

namespace App\Controller;

use App\Entity\Projets;
use App\Form\ProjetType;
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

    /**
     * @Route("/admin/projets/create", name="projet_create")
     */
    public function createprojet(Request $request)
    {
        $projet = new Projets();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $infoImg = $form['img']->getData(); // récupère les infos de l'image
                $extensionImg = $infoImg->guessExtension(); // récupère le format de l'image
                $nomImg = time() . '.' . $extensionImg; // compose un nom d'image unique
                $infoImg->move($this->getParameter('dossier_photos_projets'), $nomImg); // déplace l'image
                $projet->setImg($nomImg);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($projet);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Le projet a bien été ajouté.'
                );
            } else {
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue lors de l\'ajout de la projet'
                );
            }
            return $this->redirectToRoute('admin_projets');
        }
        return $this->render('admin/projetForm.html.twig', [
            'projetForm' => $form->createView()
        ]);
        
    }

    /**
     * @Route("/admin/projets/update-{id}", name="projet_update")
     */
    public function updateProjet(ProjetsRepository $projetsRepository, $id, Request $request)
    {
        $projet = $projetsRepository->find($id);
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $oldNomImg = $projet->getImg();
            $oldCheminImg = $this->getParameter('dossier_photos_projets') . '/' . $oldNomImg;
            if ($oldNomImg != null) {
                unlink($oldCheminImg);
            }
            $infoImg = $form['img']->getData();
            $extensionImg = $infoImg->guessExtension();
            $nomImg = time() . '.' . $extensionImg;
            $infoImg->move($this->getParameter('dossier_photos_projets'), $nomImg);
            $projet->setImg($nomImg);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($projet);
            $manager->flush();
            $this->addFlash(
                'success',
                'Le projet a bien été modifié'
            );
            return $this->redirectToRoute('admin_projets');
        }
        return $this->render('admin/projetForm.html.twig', [
            'projetForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/projets/delete-{id}", name="projet_delete")
     */
    public function deleteProjet(ProjetsRepository $projetsRepository, $id)
    {
        $projet = $projetsRepository->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($projet);
        $manager->flush();
        $this->addFlash(
            'success',
            'Le projet a bien été supprimé'
        );
        return $this->redirectToRoute('admin_projets');
    }

}
