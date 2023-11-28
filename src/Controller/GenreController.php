<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/genre', name: 'genre_')]
class GenreController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private RequestStack $requestStack)
    {
    }

    #[Route('/list', name: 'list')]
    public function listGenre()
    {
        return $this->render('listFilm.html.twig');
    }

    #[Route('/add', name: 'add')]
    public function addFilm(Request $request, EntityManagerInterface $entityManager): Response
    {
        $genre = new Genre();
        $genreForm = $this->createForm(GenreType::class, $genre);

        $genreForm->handleRequest($request);

        if ($genreForm->isSubmitted() && $genreForm->isValid()) {
            $entityManager->persist($genre);
            $entityManager->flush();

            $this->addFlash('succes-add', 'Genre ajoutée avec succès !');

            return $this->redirectToRoute('genre_list');
        }

        return $this->render('addGenre.html.twig', [
            'genreForm' => $genreForm->createview(),
        ]);
    }

    #[Route('/update/{id}', name: 'update')]
    public function updateGenre(Genre $genre)
    {
        $genreForm = $this->createForm(GenreType::class, $genre);
        $genreForm->handleRequest($this->requestStack->getCurrentRequest());

        if ($genreForm->isSubmitted() && $genreForm->isValid()) {

            $this->entityManager->flush();

            $this->addFlash('succes-update', 'Genre modifié avec succès !');

            return $this->redirectToRoute('genre_list');
        }

        return $this->render('addGenre.html.twig', [
            'genreForm' => $genreForm->createview(),
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteGenre(Genre $genre)
    {
        $this->entityManager->remove($genre);
        $this->entityManager->flush();

        $this->addFlash('succes-delete', 'Genre supprimé avec succès !');

        return $this->redirectToRoute('genre_list');
    }
}
