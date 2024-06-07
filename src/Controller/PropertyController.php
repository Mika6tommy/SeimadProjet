<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Province;
use Doctrine\ORM\EntityManager;
use App\Repository\PropertyRepository;
use App\Repository\ProvinceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{
    private $repository;
    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    #[Route('/properties', name: 'app_property')]
    public function index(PropertyRepository $propertyRepository, ProvinceRepository $provinceRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $paginator = $propertyRepository->PaginatorProperty($page, $limit);
        $maxPage = ceil($paginator->count() / $limit);
        $properties = iterator_to_array($paginator->getIterator());
        $provinces = $provinceRepository->findAll();

        return $this->render('uproperty/index.html.twig', [
            'properties' => $properties,
            'maxPage' => $maxPage,
            'page' => $page,
            'provinces' => $provinces,
        ]);
    }

    #[Route('/biens/{slug}-{id<[0-9]+>}', name: 'app_property_show', requirements: ['slug' => '[a-z0-9\-]*'])]
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('app_property_show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug(),
            ], 301);
        }

        return $this->render('uproperty/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties',
        ]);
    }

    #[Route('/api/property', name: 'app_Get', methods: 'GET')]
    public function GetProperty(PropertyRepository $propertyRepository): JsonResponse
    {
        return $this->json($propertyRepository->findAll(), 200, [], ['groups' => 'property:read']);
    }

    #[Route('/api/properties/by-province/{id}', name: 'app_properties_by_province', methods: 'GET')]
    public function getPropertiesByProvince(Province $province): JsonResponse
    {
        $properties = $province->getProperties();
        $propertiesArray = [];

        foreach ($properties as $property) {
            $propertiesArray[] = [
                'id' => $property->getId(),
                'title' => $property->getTitle(),
                'slug' => $property->getSlug(),
                'Lien' => $property->getLien(),
                'formatedPrice' => $property->getFormatedPrice(),
                'formatedDate' => $property->getFormatedDate()
            ];
        }

        return new JsonResponse($propertiesArray);
    }
}