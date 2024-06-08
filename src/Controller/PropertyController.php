<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Province;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PropertyRepository;
use App\Repository\ProvinceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
    public function show(Property $property, string $slug, Request $request, MailerInterface $mailer): Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('app_property_show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug(),
            ], 301);
        }

        // Create the contact form
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $address = $data['Email'];
            $emailBody = $data['Contenu'];
            $email = (new Email())
                ->from($address)
                ->to('tommyhas743@gmail.com')
                ->subject('Prise de Contact')
                ->text('Salutations')
                ->html($emailBody);

            $mailer->send($email);

            return $this->redirectToRoute('app_property_show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug(),
            ]);
        }

        return $this->render('uproperty/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/api/property', name: 'app_Get', methods: 'GET')]
    public function getProperty(PropertyRepository $propertyRepository): JsonResponse
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
                'formatedDate' => $property->getFormatedDate(),
            ];
        }

        return new JsonResponse($propertiesArray);
    }
}
