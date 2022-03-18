<?php

namespace App\Controller\Admin;

use App\Entity\Character;
use App\Entity\Equipment;
use App\Entity\EquipmentType;
use App\Entity\Faction;
use App\Entity\Guild;
use App\Entity\Rarity;
use App\Entity\Resource;
use App\Entity\Shop;
use App\Entity\Speciality;
use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UtilisateurCrudController::class)->generateUrl());

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
            ->setTitle('Hackathon');
    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-list', Utilisateur::class);
        yield MenuItem::linkToCrud('Character', 'fas fa-list', Character::class);
        yield MenuItem::linkToCrud('Speciality', 'fas fa-list', Speciality::class);
        yield MenuItem::linkToCrud('Faction', 'fas fa-list', Faction::class);
        yield MenuItem::linkToCrud('Guild', 'fas fa-list', Guild::class);
        yield MenuItem::linkToCrud('Rarity', 'fas fa-list', Rarity::class);
        yield MenuItem::linkToCrud('Equipment', 'fas fa-list', Equipment::class);
        yield MenuItem::linkToCrud('EquipmentType', 'fas fa-list', EquipmentType::class);
        yield MenuItem::linkToCrud('Resource', 'fas fa-list', Resource::class);
        yield MenuItem::linkToCrud('Shop', 'fas fa-list', Shop::class);
    }
}
