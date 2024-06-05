<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function index(Request $request, PropertyRepository $PropertyRepository ): Response
    {

        
        $search = $request->query->get('search');
        $properties= $PropertyRepository->findBySearch($search);
        
        return $this->render('recherche/index.html.twig', [
            'controller_name' => 'RechercheController',
             'properties' => $properties
        ]);
    }
}
