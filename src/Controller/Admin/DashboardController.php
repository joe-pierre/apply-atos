<?php

namespace App\Controller\Admin;

use App\Entity\Position;
use App\Entity\Applicant;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\ApplicantCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(ApplicantCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ACME Dashboard');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Go back to website', 'fa fa-home', '/');

        // yield MenuItem::section('Users');
        // yield MenuItem::linkToCrud('Users List', 'fas fa-list', User::class);
        
        yield MenuItem::section('Applications');
        yield MenuItem::linkToCrud('Applicants list', 'fas fa-id-card', Applicant::class);
        
        yield MenuItem::section('Positions');
        yield MenuItem::linkToCrud('All positions', 'fas fa-clipboard-list', Position::class);
    }
}