<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Entity\Category;
use App\Entity\Publisher;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('BookStore Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Authors', 'fa-solid fa-feather', Author::class);
        yield MenuItem::linkToCrud('Categories', 'fa-solid fa-list-ul', Category::class);
        yield MenuItem::linkToCrud('Publishers', 'fa-solid fa-book-open-reader', Publisher::class);
    }
}
