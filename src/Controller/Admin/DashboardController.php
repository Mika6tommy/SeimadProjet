<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Property;
use App\Entity\Actualite;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private ChartBuilderInterface $chartBuilder)
    {
        // ...
    }
    
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);

    $chart->setData([
        'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        'datasets' => [
            [
                'label' => 'My First dataset',
                'backgroundColor' => 'rgb(0, 0, 0)',
                'borderColor' => 'rgb(0, 0, 0)',
                'data' => [0, 10, 5, 2, 20, 30, 45],
            ],
        ],
    ]);

    $chart->setOptions([
        'scales' => [
            'y' => [
                'suggestedMin' => 0,
                'suggestedMax' => 100,
            ],
        ],
    ]);

    return $this->render('admin/dashboard.html.twig', [
        'chart' => $chart,
    ]);
}

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SEIMAD SA - ADMIN')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Propriété', 'fas fa-home', Property::class);
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Actualité', 'fas fa-map', Actualite::class);
    }
}
