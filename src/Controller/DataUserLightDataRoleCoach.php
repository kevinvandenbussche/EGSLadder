<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DataUserLightDataRoleCoach extends AbstractController
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(): Response
    {
        $datas = $this->userRepository->findUserLight();
        $arrayWithUserRoleUser = [];
        foreach ($datas as $data) {
            foreach ($data['roles'] as $role) {
                if ($role === 'ROLE_COACH'){
                    $arrayWithUserRoleUser[] = $data;
                }
            }
        }
        return new Response(json_encode($arrayWithUserRoleUser));
    }

}
