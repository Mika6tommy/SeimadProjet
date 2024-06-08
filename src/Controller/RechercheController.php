<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function index(Request $request, PropertyRepository $propertyRepository): Response
    {
        $search = $request->query->get('search');
        $properties = $propertyRepository->findBySearch($search);

        if ($request->isXmlHttpRequest()) {
            $results = [];
            foreach ($properties as $property) {
                $results[] = [
                    'title' => $property->getTitle(),
                    'id' => $property->getId(),
                    // Ajoutez d'autres champs si nécessaire
                ];
            }
            return new JsonResponse($results);
        }

        return $this->render('recherche/index.html.twig', [
            'controller_name' => 'RechercheController',
            'properties' => $properties,
        ]);
    }
}


