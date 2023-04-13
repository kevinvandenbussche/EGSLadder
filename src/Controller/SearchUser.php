<?php

namespace App\Controller;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use function Symfony\Component\String\u;

#[ApiResource(
    collectionOperations: [
        'get' => [
            'path' => 'api/search-player/{string}',
            'status' => 200,
        ],
    ],
    itemOperations: [
        'get' => [
            'path' => 'api/search-player/{string}',
            'defaults' => ['color' => 'brown'],
            'options' => ['my_option' => 'my_option_value'],
            'schemes' => ['https'],
            'host' => '{subdomain}.api-platform.com',
        ],
    ],
)]
#[AsController]

class SearchUser extends AbstractController
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke($string): Response
    {
        $arrayRoleUser = [];
        if (!preg_match('/<script\ +>/', $string)) {
            $users = $this->userRepository->searchBarreUser($string);
            foreach ($users as $user) {
                foreach ($user['roles'] as $role){
                    if ($role === 'ROLE_USER' || $role === 'ROLE_ADMIN'){
                        $arrayRoleUser[] = $user;
                    }
                }
            }
            return new Response(
                json_encode($arrayRoleUser)
            );
        } else {
            return new Response(
                json_encode('error')
            );
        }
    }
}

