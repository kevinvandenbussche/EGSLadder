<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DataGame extends AbstractController
{
    #[Route('api/data-game', name: 'data_game', methods: "GET")]
    public function dataGame(GameRepository $gameRepository): JsonResponse
    {
        $games = $gameRepository->findGame();
        return new JsonResponse(
            $games
        );
    }
}
