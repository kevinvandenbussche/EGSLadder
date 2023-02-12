<?php

namespace App\Controller;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

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

class SearchPlayer extends AbstractController
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke($string): Response
    {
        if (!preg_match('/<script\ +>/', $string)) {
            $users = $this->userRepository->searchBarre($string);
            return new Response(
                json_encode($users)
            );
        } else {
            return new Response(
                json_encode('error')
            );
        }
    }
}

