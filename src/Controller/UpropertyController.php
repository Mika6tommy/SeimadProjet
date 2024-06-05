<?php

namespace App\Controller;

use App\Entity\Property;
use App\Form\Property1Type;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/uproperty')]
class UpropertyController extends AbstractController
{
    #[Route('/', name: 'app_uproperty_index', methods: ['GET'])]
    public function index(PropertyRepository $propertyRepository): Response
    {
        return $this->render('uproperty/index.html.twig', [
            'properties' => $propertyRepository->findAll(),
        ]);
    }

    // #[Route('/{id}', name: 'app_uproperty_show', methods: ['GET'])]
    // public function show(Property $property): Response
    // {
    //     return $this->render('uproperty/show.html.twig', [
    //         'property' => $property,
    //     ]);
    // }
  
    #[Route('/biens/{slug}-{id<[0-9]+>}', name: 'app_uproperty_show', requirements: ['slug' => '[a-z0-9\-]*'], methods: ['GET'])]
    public function show(Property $property, string $slug): Response
{
    if ($property->getSlug() !== $slug) {
        return $this->redirectToRoute('app_uproperty_show', [
         //   'property' => $property,
            'id' => $property->getId(),
            'slug' => $property->getSlug(),
        ], 301);
    }

    return $this->render('uproperty/show.html.twig', [
        'property' => $property,
         'current_menu' => 'properties',
    ]);
}
}
   