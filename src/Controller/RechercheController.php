<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            return $this->render('recherche/index.html.twig', [
                'properties' => $properties,
            ]);
        }

        return $this->render('recherche/index.html.twig', [
            'controller_name' => 'RechercheController',
            'properties' => $properties,
        ]);
    }
}

