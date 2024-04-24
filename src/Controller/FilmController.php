<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/film', name: "app_film_")]
class FilmController extends AbstractController
{
    #[Route('s', name: 'index')]
    public function index(FilmRepository $filmRepository): Response
    {
        $films = $filmRepository->findAll();
        return $this->render('film/index.html.twig', [
            'films' => $films,
        ]);
    }

    #[Route('/{id}', name:'show', methods:['GET'], requirements: ['id' => '\d+'])]
    public function show(Film $film): Response
    {
        return $this->render('film/show.html.twig', [
            'film' => $film,
        ]);
    }

    #[Route('/new', name: "new", methods:['GET', 'POST'], priority: 1)]
    public function new(Request $request){
        $form = $this->createForm(FilmType::class);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid){
            $film = $form->getData();
            $em->persist($film);
            $em->flush();
            $this->addFlash('success', 'Le film est bien engregistré');
            return $this->redirectToRoute('app_film_show', ['nom' => $film->getNom()]);
        }
        return $this->render('film/new.html.twig', [
            'formNew' => $form
        ]);
    }

    #[Route('/{id}/delete', name: 'delete')]
    public function delete(Film $film)
    {
        $em->remove($film);
        $em->flush();
        $this->addFlash('success', 'le film a bien été supprimé');
        return $this->redirectToRoute('app_film_delete');
    }

    #[Route('/{id}/update', name: 'update')]
    public function update(film $film, request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $film = $form->getData();
            $em->flush();

            $this->addFlash('success', 'Film a bien été modifié');
            return $this->redirectToRoute('app_film_show', ['nom' =>$film->getNom()]);
        }
        return $this->render('path film;html.twig');
    }

}