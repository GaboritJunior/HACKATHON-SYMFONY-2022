<?php

namespace App\Controller;

use App\Entity\CharacterEquipment;
use App\Form\CharacterEquipmentType;
use App\Repository\CharacterEquipmentRepository;
use App\Repository\CharacterResourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/character/equipment')]
class CharacterEquipmentController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/inventory', name: 'app_character_equipment_index', methods: ['GET'])]
    public function index(CharacterEquipmentRepository $characterEquipmentRepository, CharacterResourceRepository $characterResourceRepository): Response
    {
        $session = $this->requestStack->getSession();


        return $this->render('character_equipment/index.html.twig', [

            'character_equipments' => $characterEquipmentRepository->findBy(['player'=>$session->get('character')]),
            'character_resource' => $characterResourceRepository->findBy(['player'=>$session->get('character')])
        ]);
    }

    #[Route('/new', name: 'app_character_equipment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CharacterEquipmentRepository $characterEquipmentRepository): Response
    {
        $characterEquipment = new CharacterEquipment();
        $form = $this->createForm(CharacterEquipmentType::class, $characterEquipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $characterEquipmentRepository->add($characterEquipment);
            return $this->redirectToRoute('app_character_equipment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('character_equipment/new.html.twig', [
            'character_equipment' => $characterEquipment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_character_equipment_show', methods: ['GET'])]
    public function show(CharacterEquipment $characterEquipment): Response
    {
        return $this->render('character_equipment/show.html.twig', [
            'character_equipment' => $characterEquipment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_character_equipment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CharacterEquipment $characterEquipment, CharacterEquipmentRepository $characterEquipmentRepository): Response
    {
        $form = $this->createForm(CharacterEquipmentType::class, $characterEquipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $characterEquipmentRepository->add($characterEquipment);
            return $this->redirectToRoute('app_character_equipment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('character_equipment/edit.html.twig', [
            'character_equipment' => $characterEquipment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_character_equipment_delete', methods: ['POST'])]
    public function delete(Request $request, CharacterEquipment $characterEquipment, CharacterEquipmentRepository $characterEquipmentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$characterEquipment->getId(), $request->request->get('_token'))) {
            $characterEquipmentRepository->remove($characterEquipment);
        }

        return $this->redirectToRoute('app_character_equipment_index', [], Response::HTTP_SEE_OTHER);
    }
}
