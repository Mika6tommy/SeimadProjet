<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ImageController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/image', name: 'app_image')]
    public function index(): Response
    {
        $images = $this->entityManager->getRepository(Image::class)->findAll();
        return $this->render('image/index.html.twig', [
            'images' => $images,
            'controller_name' => 'ImageController',
        ]);
    }

    #[Route('/upload', name:'upload_image')]
    public function uploadImage(Request $request): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($image);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_image');
        }

        return $this->render('image/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/image/{id}', name: 'app_image_show')]
    public function show($id): Response
    {
        $image = $this->entityManager->getRepository(Image::class)->find($id);

        if (!$image) {
            throw $this->createNotFoundException('The image does not exist');
        }

        $response = new Response();
        $response->headers->set('Content-Type', 'image/jpeg');
        $response->setContent(stream_get_contents($image->getImageData()));

        return $response;
    }
}
