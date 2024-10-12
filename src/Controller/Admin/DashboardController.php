<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Property;
use App\Entity\Actualite;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\PropertyRepository;
use App\Repository\ActualiteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    private ActualiteRepository $actualiteRepository;
    private PropertyRepository $propertyRepository;
    public function __construct(ChartBuilderInterface $chartBuilder,ActualiteRepository $actualiteRepository,PropertyRepository $propertyRepository)
    {
        $this->actualiteRepository = $actualiteRepository;
        $this->propertyRepository = $propertyRepository;

    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $data = $this->actualiteRepository->countByDate();
        $data1 = $this->propertyRepository->countByDate();
        
        return $this->render('admin/dashboard.html.twig', [
            'data' => $data,
            'data1' => $data1,
        ]);
        
    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            // ->setTitle('ADMINISTRATEUR - SEIMAD')
            ->setTitle('<img src="../assets/img/favicon.png" class="img-fluid d-block mx-auto" style="max-width:100px; width:100%;"><h2 class="mt-3 fw-bold text-white text-center">ADMIN - SEIMAD</h2>')
            // ->renderSidebarMinimized()
            
            // ->generateRelativeUrls()
            // ->setFaviconPath('favicon.svg')
            ->renderContentMaximized();
    }
    public function configureAssets(): Assets
{
    return parent::configureAssets()
    ->addWebpackEncoreEntry('admin');
}

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Accueil du site', 'fa-arrow-left', '/');
        yield MenuItem::section(' ');
        yield MenuItem::linkToDashboard('dashboard', 'fa fa-map');
        yield MenuItem::linkToCrud('Propriété', 'fas fa-home', Property::class);
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Actualité', 'fas fa-bullhorn', Actualite::class);
    }
}
