<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Acteur;
use App\Entity\Film;
use App\Entity\Genre;
use App\Entity\Realisateur;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchType;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/film', name: 'film_')]
class FilmController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private RequestStack $requestStack)
    {

    }

    #[Route('/list', name: 'list')]
    public function listFilm(FilmRepository $filmRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $genres = $entityManager->getRepository(Genre::class)->findAll();
        $realisateurs = $entityManager->getRepository(Realisateur::class)->findAll();
        $acteurs = $entityManager->getRepository(Acteur::class)->findAll();

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        $searchTerm = $request->query->get('q');

        $films = $filmRepository->sort($searchTerm, $searchData);

        return $this->render('listFilm.html.twig', [

            'films' => $films,
            'genres' => $genres,
            'realisateurs' => $realisateurs,
            'acteurs' => $acteurs,
            'form' => $form->createView()
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addFilm(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, FileUploader $fileUploader): Response
    {
        $film = new Film();
        $filmForm = $this->createForm(FilmType::class, $film);

        $filmForm->handleRequest($request);

        if ($filmForm->isSubmitted() && $filmForm->isValid()) {
            $pictureFile = $filmForm->get('jaquette')->getData();
            $wallpaperFile = $filmForm->get('wallpaper')->getData();

            if ($pictureFile) {
                $pictureFileName = $fileUploader->upload($pictureFile);
                $film->setJaquette($pictureFileName);
            }

            if ($wallpaperFile) {
                $wallpaperFileName = $fileUploader->upload($wallpaperFile);
                $film->setWallpaper($wallpaperFileName);
            }

            $entityManager->persist($film);
            $entityManager->flush();

            $this->addFlash('succes-add', 'Film ajoutée avec succès !');

            return $this->redirectToRoute('film_detail', ['id' => $film->getId()]);
        }

        return $this->render('addFilm.html.twig', [
            'filmForm' => $filmForm->createview(),
        ]);
    }

    #[Route('/detail/{id}', name: 'detail')]
    public function detailFilm(int $id, FilmRepository $filmRepository): Response
    {
        $film = $filmRepository->find($id);

        return $this->render('detailFilm.html.twig', [
            'film' => $film
        ]);
    }

    #[Route('/update/{id}', name: 'update')]
    public function updateFilm(Film $film, FileUploader $fileUploader): Response
    {
        $filmForm = $this->createForm(FilmType::class, $film);
        $filmForm->handleRequest($this->requestStack->getCurrentRequest());

        if ($filmForm->isSubmitted() && $filmForm->isValid()) {
            $pictureFile = $filmForm->get('jaquette')->getData();
            $wallpaperFile = $filmForm->get('wallpaper')->getData();

            if ($pictureFile) {
                $pictureFileName = $fileUploader->upload($pictureFile);
                $film->setJaquette($pictureFileName);
            }

            if ($wallpaperFile) {
                $wallpaperFileName = $fileUploader->upload($wallpaperFile);
                $film->setWallpaper($wallpaperFileName);
            }

            $this->entityManager->flush();

            $this->addFlash('succes-update', 'Film modifié avec succès !');

            return $this->redirectToRoute('film_detail', ['id' => $film->getId()]);
        }

        return $this->render('addFilm.html.twig', [
            'filmForm' => $filmForm->createview(),
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteFilm(Film $film)
    {
        $this->entityManager->remove($film);
        $this->entityManager->flush();

        $this->addFlash('succes-delete', 'Film supprimé avec succès !');

        return $this->redirectToRoute('film_list');
    }
}
