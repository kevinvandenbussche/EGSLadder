<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SearchCoach extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke($string): Response
    {
        $arrayRoleCoach = [];
        if (!preg_match('/<script\ +>/', $string)) {
            $users = $this->userRepository->searchBarreUser($string);
            foreach ($users as $user) {
                foreach ($user['roles'] as $role) {
                    if ($role === 'ROLE_COACH') {
                        $arrayRoleCoach[] = $user;
                    }
                }
            }
            return new Response(
                json_encode($arrayRoleCoach)
            );
        } else {
            return new Response(
                json_encode('error')
            );
        }
    }
}
