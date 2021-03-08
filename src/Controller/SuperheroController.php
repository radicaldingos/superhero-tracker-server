<?php

namespace App\Controller;

use App\Entity\Superhero;
use App\Repository\SuperheroRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SuperheroController extends ApiController
{
    /**
     * @Route("/superheroes", methods="GET")
     */
    public function index(SuperheroRepository $superheroRepository): JsonResponse
    {
        $movies = $superheroRepository->transformAll();

        return $this->respond($movies);
    }

    /**
     * @Route("/superheroes", methods="POST")
     */
    public function create(Request $request, SuperheroRepository $superHeroRepository): JsonResponse
    {
        $request = $this->transformJsonBody($request);
        if (!$request) {
            return $this->respondValidationError("Requête invalide.");
        }

        $name = $request->get('name');
        if (!$name) {
            return $this->respondValidationError("Nom manquant.");
        }

        $superhero = new Superhero();
        $superhero->setName($name);
        $superhero->setBirth(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($superhero);
        $em->flush();

        return $this->respondCreated($superHeroRepository->transform($superhero));
    }

    /**
     * @Route("/superheroes/{id}", methods="DELETE")
     */
    public function delete($id, SuperheroRepository $superHeroRepository)
    {
        $superhero = $superHeroRepository->find($id);

        if (null === $superhero) {
            return $this->respondNotFound();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($superhero);
        $em->flush();

        return $this->respond([]);
    }
}
