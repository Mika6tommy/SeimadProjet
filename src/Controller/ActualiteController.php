<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Form\Actualite1Type;
use App\Repository\ActualiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/actualite')]
class ActualiteController extends AbstractController
{
    #[Route('/', name: 'app_actualite_index', methods: ['GET'])]
    public function index(ActualiteRepository $actualiteRepository): Response
    {
        // Utilisez une méthode existante pour obtenir les actualités
        $actualites = $actualiteRepository->findAll();

        return $this->render('actualite/index.html.twig', [
            'actualites' => $actualites,
        ]);
    }

    #[Route('/{id}', name: 'app_actualite_show', methods: ['GET'])]
    public function show(Actualite $actualite): Response
    {
        return $this->render('actualite/show.html.twig', [
            'actualite' => $actualite,
        ]);
    }
   
   #[Route('/load-more-actualites', name: 'load_more_actualites', methods: ["GET"])]
     
    public function loadMoreActualites(Request $request): JsonResponse
    {
        // Récupérez la page demandée depuis la requête
        $page = $request->query->getInt('page', 1);

        // Nombre d'actualités à charger par page
        $limit = 10;

        // Calculez l'offset en fonction de la page et du nombre d'actualités par page
        $offset = ($page - 1) * $limit;

        // Récupérez les actualités suivantes depuis la base de données
        $actualites = $this->getDoctrine()->getRepository(Actualite::class)
            ->findBy([], null, $limit, $offset);

        // Créez une réponse JSON contenant le HTML des actualités
        $html = $this->renderView('actualite/_actualites.html.twig', [
            'actualites' => $actualites,
        ]);

        return new JsonResponse($html);
    }

}
