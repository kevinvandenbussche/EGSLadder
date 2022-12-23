<?php

namespace App\Controller;

use App\Repository\ToPlayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class FindElo extends AbstractController
{
    #[Route('api/find-elo-by-user/{id}', name: 'find_elo', methods: "GET")]
    public function findEloByUser(ToPlayRepository $toPlayRepository, $id): JsonResponse
    {
        $elo = $toPlayRepository->findAllEloByUser($id);
        return new JsonResponse(
            $elo
        );
    }

}
