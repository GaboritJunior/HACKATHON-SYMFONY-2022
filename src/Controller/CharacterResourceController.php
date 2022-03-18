<?php

namespace App\Controller;

use App\Entity\CharacterResource;
use App\Form\CharacterResourceType;
use App\Repository\CharacterResourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/character/resource')]
class CharacterResourceController extends AbstractController
{
    #[Route('/', name: 'app_character_resource_index', methods: ['GET'])]
    public function index(CharacterResourceRepository $characterResourceRepository): Response
    {
        return $this->render('character_resource/index.html.twig', [
            'character_resources' => $characterResourceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_character_resource_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CharacterResourceRepository $characterResourceRepository): Response
    {
        $characterResource = new CharacterResource();
        $form = $this->createForm(CharacterResourceType::class, $characterResource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $characterResourceRepository->add($characterResource);
            return $this->redirectToRoute('app_character_resource_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('character_resource/new.html.twig', [
            'character_resource' => $characterResource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_character_resource_show', methods: ['GET'])]
    public function show(CharacterResource $characterResource): Response
    {
        return $this->render('character_resource/show.html.twig', [
            'character_resource' => $characterResource,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_character_resource_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CharacterResource $characterResource, CharacterResourceRepository $characterResourceRepository): Response
    {
        $form = $this->createForm(CharacterResourceType::class, $characterResource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $characterResourceRepository->add($characterResource);
            return $this->redirectToRoute('app_character_resource_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('character_resource/edit.html.twig', [
            'character_resource' => $characterResource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_character_resource_delete', methods: ['POST'])]
    public function delete(Request $request, CharacterResource $characterResource, CharacterResourceRepository $characterResourceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$characterResource->getId(), $request->request->get('_token'))) {
            $characterResourceRepository->remove($characterResource);
        }

        return $this->redirectToRoute('app_character_resource_index', [], Response::HTTP_SEE_OTHER);
    }
}
