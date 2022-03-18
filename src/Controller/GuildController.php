<?php

namespace App\Controller;

use App\Entity\Guild;
use App\Form\GuildType;
use App\Repository\CharacterRepository;
use App\Repository\GuildRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/guild')]
class GuildController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/', name: 'app_guild_index', methods: ['GET'])]
    public function index(GuildRepository $guildRepository): Response
    {
        return $this->render('guild/index.html.twig');
    }

    #[Route('/list', name: 'app_guild_list', methods: ['GET'])]
    public function list(GuildRepository $guildRepository): Response
    {
        return $this->render('guild/list.html.twig', [
            'guilds' => $guildRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_guild_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GuildRepository $guildRepository, CharacterRepository $characterRepository): Response
    {
        $error = "";

        $session = $this->requestStack->getSession();

        $character = $characterRepository->findOneBy(['id' => $session->get('character')]);

        $guild = new Guild();
        $form = $this->createForm(GuildType::class, $guild);
        $form->handleRequest($request);
        dd($session->get('character'));

        if ($form->isSubmitted() && $form->isValid()) {

            if($character->getMoney() >= 100) {
                // $character->setMoney($character->getMoney() - 100);
                $guild->setCreator($character);
                $guild->addCharacter($character);
                $guildRepository->add($guild);

                return $this->redirectToRoute('app_guild_show', ['id' => $guild->getId()]);

            } else {
                $error = "Vous n'avez pas assez d'or pour créer une guilde";
            }

        }

        return $this->renderForm('guild/new.html.twig', [
            'guild' => $guild,
            'form' => $form,
            'error' => $error
        ]);
    }

    #[Route('/{id}', name: 'app_guild_show', methods: ['GET'])]
    public function show(Guild $guild, CharacterRepository $characterRepository): Response
    {
        $session = $this->requestStack->getSession();

        $character = $characterRepository->findOneBy(['id' => $session->get('character')]);

        $isGuildMember = ($character->getGuild() === $guild);

        return $this->render('guild/show.html.twig', [
            'guild' => $guild,
            'characters' => $guild->getCharacters(),
            'isGuildMember' => $isGuildMember
        ]);
    }

    #[Route('/{id}/join', name: 'app_guild_join', methods: ['GET'])]
    public function join(Guild $guild, CharacterRepository $characterRepository, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $session = $this->requestStack->getSession();

        $character = $characterRepository->findOneBy(['id' => $session->get('character')]);

        //$guild->addCharacter($character);
        $character->setGuild($guild);
        $entityManager->flush();

        return $this->redirectToRoute('app_guild_show', ['id' => $guild->getId()]);
    }

    #[Route('/{id}/leave', name: 'app_guild_leave', methods: ['GET'])]
    public function leave(Guild $guild, CharacterRepository $characterRepository, ManagerRegistry $doctrine, GuildRepository $guildRepository): Response
    {
        $entityManager = $doctrine->getManager();

        $session = $this->requestStack->getSession();

        $character = $characterRepository->findOneBy(['id' => $session->get('character')]);

        if($character->getId() === $guild->getCreator()->getId()) {
            $guild->removeCharacter($character);
            // $guildRepository->remove($guild);
        } else {
            $guild->removeCharacter($character);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_guild_index', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/{id}/edit', name: 'app_guild_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Guild $guild, GuildRepository $guildRepository): Response
    {
        $form = $this->createForm(GuildType::class, $guild);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $guildRepository->add($guild);
            return $this->redirectToRoute('app_guild_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('guild/edit.html.twig', [
            'guild' => $guild,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_guild_delete', methods: ['POST'])]
    public function delete(Request $request, Guild $guild, GuildRepository $guildRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$guild->getId(), $request->request->get('_token'))) {
            $guildRepository->remove($guild);
        }

        return $this->redirectToRoute('app_guild_index', [], Response::HTTP_SEE_OTHER);
    }
}

