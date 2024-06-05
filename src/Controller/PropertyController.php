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
    public function index(PropertyRepository $propertyRepository, Request $request,ProvinceRepository $provinceRepository): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $paginator = $propertyRepository->PaginatorProperty($page, $limit);
        $maxPage = ceil($paginator->count() / $limit);
        $properties = iterator_to_array($paginator->getIterator());
        $provinces = $provinceRepository->findAll();

        return $this->render('uproperty/index.html.twig', [
            'properties' => $properties,
            'provinces' => $provinces,
            'maxPage' => $maxPage,
            'page' => $page 
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

    #[Route('/api/property', name:'app_Get', methods:'GET')]
    public function GetProperty(PropertyRepository $propertyRepository): JsonResponse
    {
        return $this->json($propertyRepository->findAll(), 200, [], ['groups' => 'property:read']);
    }

    #[Route('/provinces', name: 'app_provinces')]
    public function listProvinces(ProvinceRepository $provinceRepository): Response
    {
        $provinces = $provinceRepository->findAll();

        return $this->render('uproperty/provinces.html.twig', [
            'provinces' => $provinces,
        ]);
    }

    #[Route('/properties/province/{id}', name: 'app_properties_by_province')]
    public function showByProvince(Province $province): Response
    {
        $properties = $province->getProperties();

        return $this->render('uproperty/show_by_province.html.twig', [
            'properties' => $properties,
            'province' => $province,
        ]);
    }
}
