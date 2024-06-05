<?php

namespace App\Controller;

use App\Entity\Property;
use Doctrine\ORM\EntityManager;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController

{
    private $repository;
    private $em;
    public function __construct(PropertyRepository $repository,EntityManagerInterface $em)
    {
        $this-> repository = $repository;
        $this -> em = $em;
    }
    #[Route('/properties', name: 'app_property')]
    public function index(PropertyRepository $propertyRepository,Request $request): Response
    {
        
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        //$properties = $propertyRepository->PaginatorProperty($request); 
        $paginator = $propertyRepository->PaginatorProperty($page, $limit);
        $maxPage = ceil($paginator->count() / $limit);
        // dd($property->count());
        $properties = iterator_to_array($paginator->getIterator());
        return $this->render('uproperty/index.html.twig', [
            'properties' => $properties,
            'maxPage' => $maxPage,
            'page' => $page 
            
        ]);
    }

   
    #[Route('/biens/{slug}-{id<[0-9]+>}', name: 'app_property_show', requirements: ['slug' => '[a-z0-9\-]*'])]

public function show(Property $property, string $slug): Response
{
    if ($property->getSlug() !== $slug) {
        return $this->redirectToRoute('app_property_show', [
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

#[Route('/api/property' , name:'app_Get', methods:'GET')]
public function GetProperty(PropertyRepository $propertyRepository): JsonResponse
{
    return $this->json($propertyRepository->findAll(),200,[],['grous'=>'property:read']);
}

}
