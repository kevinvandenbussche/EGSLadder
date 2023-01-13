<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\Translation\t;

class DataUserForMainPage extends AbstractController
{
    #[Route('api/data-user-for-main-page', name: 'data_user_for_main_page', methods: "GET")]
    public function dataUserForMainPage( UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findPeudonymeUniqueByUser();
        return new JsonResponse(
            $users
        );
    }

    #[Route('api/games-by-player/{id}', name: 'games-by-player', methods: "GET")]
    public function gamesByPlayer($id, UserRepository $userRepository): JsonResponse
    {
        $games = $userRepository->findGamesByUser($id);
        return new JsonResponse(
            $games
        );
    }

    #[Route('api/search-player/{string}', name: 'search-player', methods: "GET")]
    public function searchPlayer($string, UserRepository $userRepository): JsonResponse
    {
        if (!preg_match('/<script\ +>/', $string)) {
            $users = $userRepository->searchBarre($string);
            return new JsonResponse(
                $users
            );
        } else {
            return new JsonResponse(
                t('error')
            );
        }
    }
}



