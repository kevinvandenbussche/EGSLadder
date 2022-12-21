<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DataUserForMainPage extends AbstractController
{
    #[Route('api/data-user-for-main-page', name: 'data_user_for_main_page', methods: "GET")]
    public function dataUserForMainPage( UserRepository $userRepository)
    {
        $users = $userRepository->findPeudonymeUniqueByUser();

        return new JsonResponse(
            $users
        );
    }
}
{

}
