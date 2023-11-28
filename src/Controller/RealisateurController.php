<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Entity\Realisateur;
use App\Form\RealisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/realisateur', name: 'realisateur_')]
class RealisateurController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private RequestStack $requestStack)
    {
    }

    #[Route('/list', name: 'list')]
    public function listRealisateur()
    {
        return $this->render('listFilm.html.twig');
    }

    #[Route('/add', name: 'add')]
    public function addFilm(Request $request, EntityManagerInterface $entityManager): Response
    {
        $realisateur = new Realisateur();
        $realisateurForm = $this->createForm(RealisateurType::class, $realisateur);

        $realisateurForm->handleRequest($request);

        if ($realisateurForm->isSubmitted() && $realisateurForm->isValid()) {
            $entityManager->persist($realisateur);
            $entityManager->flush();

            $this->addFlash('succes-add', 'Réalisateur ajoutée avec succès !');

            return $this->redirectToRoute('real_list');
        }

        return $this->render('addRealisateur.html.twig', [
            'realisateurForm' => $realisateurForm->createview(),
        ]);
    }

    #[Route('/update/{id}', name: 'update')]
    public function updateRealisateur(Realisateur $realisateur)
    {
        $realisateurForm = $this->createForm(Realisateur::class, $realisateur);
        $realisateurForm->handleRequest($this->requestStack->getCurrentRequest());

        if ($realisateurForm->isSubmitted() && $realisateurForm->isValid()) {

            $this->entityManager->flush();

            $this->addFlash('succes-update', 'Réalisateur modifié avec succès !');

            return $this->redirectToRoute('realisateur_list');
        }

        return $this->render('addRealisateur.html.twig', [
            'realisateurForm' => $realisateurForm->createview(),
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteRealisateur(Realisateur $realisateur)
    {
        $this->entityManager->remove($realisateur);
        $this->entityManager->flush();

        $this->addFlash('succes-delete', 'Réalisateur supprimé avec succès !');

        return $this->redirectToRoute('realisateur_list');
    }
}
