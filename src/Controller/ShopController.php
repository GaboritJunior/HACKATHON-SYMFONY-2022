<?php

namespace App\Controller;

use App\Entity\CharacterEquipment;
use App\Entity\Shop;
use App\Form\ShopType;
use App\Repository\CharacterEquipmentRepository;
use App\Repository\CharacterRepository;
use App\Repository\EquipmentRepository;
use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/shop')]
class ShopController extends AbstractController
{

    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/', name: 'app_shop_index', methods: ['GET'])]
    public function index(ShopRepository $shopRepository, EquipmentRepository $equipmentRepository, CharacterRepository $characterRepository): Response
    {
        $session = $this->requestStack->getSession();
        $character = $characterRepository->findOneBy(['id' => $session->get('character')]);

        //dd($shopRepository->findEquipments());
        return $this->render('shop/index.html.twig', [
            'shops' => $shopRepository->findEquipments(),
            'character' => $character
        ]);
    }

    #[Route('/{id}/buy', name: 'app_shop_buy', methods: ['GET'])]
    public function buy(Shop $shop, CharacterRepository $characterRepository, CharacterEquipmentRepository $characterEquipmentRepository): Response
    {
        $session = $this->requestStack->getSession();
        $character = $characterRepository->findOneBy(['id' => $session->get('character')]);

        if ($character->getMoney() >= $shop->getPrice()) {
            $characterEquipment = new CharacterEquipment();
            $characterEquipment->setEquiped(false);
            $characterEquipment->setEquipment($shop->getEquipment());
            $characterEquipment->setIlvl($shop->getIlvl());
            $characterEquipment->setPlayer($character);

            $character->setMoney($character->getMoney() - $shop->getPrice());
            $characterEquipmentRepository->add($characterEquipment);
            return $this->render('shop/thanks.html.twig');
        }

        return $this->redirectToRoute('app_shop_index');
    }
}
