<?php

namespace App\Controller;

use App\Entity\Acteur;
use App\Entity\Film;
use App\Form\ActeurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/acteur', name: 'acteur_')]
class ActeurController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private RequestStack $requestStack)
    {
    }

    #[Route('/list', name: 'list')]
    public function listActeur()
    {
        return $this->render('listFilm.html.twig');
    }

    #[Route('/add', name: 'add')]
    public function addActeur(Request $request, EntityManagerInterface $entityManager): Response
    {
        $acteur = new Acteur();
        $acteurForm = $this->createForm(ActeurType::class, $acteur);

        $acteurForm->handleRequest($request);

        if ($acteurForm->isSubmitted() && $acteurForm->isValid()) {
            $entityManager->persist($acteur);
            $entityManager->flush();

            $this->addFlash('succes-add', 'Acteur ajoutée avec succès !');

            return $this->redirectToRoute('acteur_list');
        }

        return $this->render('addActeur.html.twig', [
            'acteurForm' => $acteurForm->createview(),
        ]);
    }

    #[Route('/update/{id}', name: 'update')]
    public function updateActeur(Acteur $acteur)
    {
        $acteurForm = $this->createForm(ActeurType::class, $acteur);
        $acteurForm->handleRequest($this->requestStack->getCurrentRequest());

        if ($acteurForm->isSubmitted() && $acteurForm->isValid()) {

            $this->entityManager->flush();

            $this->addFlash('succes-update', 'Acteur modifié avec succès !');

            return $this->redirectToRoute('acteur_list');
        }

        return $this->render('addActeur.html.twig', [
            'acteurForm' => $acteurForm->createview(),
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteActeur(Acteur $acteur)
    {
        $this->entityManager->remove($acteur);
        $this->entityManager->flush();

        $this->addFlash('succes-delete', 'Acteur supprimé avec succès !');

        return $this->redirectToRoute('acteur_list');
    }
}
