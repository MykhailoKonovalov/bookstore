<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Publisher;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Security\Permission;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Logout\LogoutUrlGenerator;
use function Symfony\Component\Translation\t;

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
        yield MenuItem::linkToCrud('Publishers', 'fas fa-print', Publisher::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-layer-group', Category::class);
        yield MenuItem::linkToCrud('Books', 'fa fa-book', Book::class);
        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Product', null, Product::class);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        $userMenuItems = [];

        $userMenuItems[] = MenuItem::section();
        $userMenuItems[] = MenuItem::linkToUrl('Back to site', 'fa fa-arrow-left',  '/');

        if (class_exists(LogoutUrlGenerator::class)) {
            $userMenuItems[] = MenuItem::linkToLogout(t('Logout', domain: 'EasyAdminBundle'), 'fa-sign-out');
        }

        if ($this->isGranted(Permission::EA_EXIT_IMPERSONATION)) {
            $userMenuItems[] = MenuItem::linkToExitImpersonation(t('user.exit_impersonation', domain: 'EasyAdminBundle'), 'fa-user-lock');
        }

        $userName = method_exists($user, '__toString') ? (string) $user : $user->getUserIdentifier();

        return UserMenu::new()
                       ->displayUserName()
                       ->displayUserAvatar()
                       ->setName($userName)
                       ->setAvatarUrl(null)
                       ->setMenuItems($userMenuItems);
    }
}
