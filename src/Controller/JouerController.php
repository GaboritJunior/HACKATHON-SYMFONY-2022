<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[isGranted('ROLE_JOUEUR')]
class JouerController extends AbstractController
{
    #[Route('/jouer', name: 'app_jouer')]
    public function index(): Response
    {
        return $this->render('jouer/index.html.twig', [
        ]);
    }
}
