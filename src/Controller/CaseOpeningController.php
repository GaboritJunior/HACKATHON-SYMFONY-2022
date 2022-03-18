<?php

namespace App\Controller;

use App\Entity\CharacterEquipment;
use App\Entity\Equipment;
use App\Repository\CharacterEquipmentRepository;
use App\Repository\CharacterRepository;
use App\Repository\EquipmentRepository;
use App\Repository\RarityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CaseOpeningController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/case/opening', name: 'app_case_opening')]
    public function index(): Response
    {
        return $this->render('case_opening/index.html.twig', [
            'controller_name' => 'CaseOpeningController',
        ]);
    }

    #[Route('/case/opened', name: 'app_case_opened')]
    public function opened(EquipmentRepository $equipmentRepository, CharacterEquipmentRepository $characterEquipmentRepository, RarityRepository $rarityRepository, CharacterRepository $characterRepository): Response
    {


        $session = $this->requestStack->getSession();
        $character = $characterRepository->findOneBy(['id' => $session->get('character')]);
        $rarities = $rarityRepository->findAll();

        if ($character->getMoney() >= 50) {
            $characterEquipment = new CharacterEquipment();
            $characterEquipment->setEquiped(false);

            $rand = mt_rand(0, (float) array_sum( array_map(fn($value): float => $value->getProbability(), $rarities) )*100 ) /100;
            $iteration = 0;
            while ($rand > 0) {
                $rand -= $rarities[$iteration]->getProbability();
                $iteration++;
            }
            $equipments = $equipmentRepository->findBy(
                ['rarity' => $iteration]
            );

            $equipment = $equipments[mt_rand(0, count($equipments)-1)];
            $characterEquipment->setEquipment($equipment);

            $characterEquipment->setIlvl(mt_rand($rarities[$iteration-1]->getIlvlMin(), $rarities[$iteration-1]->getIlvlMax()));
            $characterEquipment->setPlayer($character);

            $character->setMoney($character->getMoney() - 50);
            $characterEquipmentRepository->add($characterEquipment);

            return $this->render('case_opening/open.html.twig', [
                'characterEquipment' => $characterEquipment,
                'equipment' => $equipment,
            ]);
        }

        return $this->render('case_opening/open.html.twig', [
            'equipment' => null,
        ]);
    }
}
