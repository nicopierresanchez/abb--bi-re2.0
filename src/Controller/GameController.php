<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/game", name="game_")
 */
class GameController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
    /**
     * @Route("/morpion", name="morpion")
     */
    public function morpion(): Response
    {
        return $this->render('game/morpion.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
    /**
     * @Route("/pifpafpouf", name="pifpafpouf")
     */
    public function pifpafpouf(): Response
    {
        return $this->render('game/pifpafpouf.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
}
