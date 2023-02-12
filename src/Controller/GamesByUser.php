<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use ApiPlatform\Core\Annotation\ApiResource;


#[ApiResource(
    collectionOperations: [
        'get' => [
            'path' => 'api/games-by-player/{id}',
            'status' => 200,
        ],
    ],
    itemOperations: [
        'get' => [
            'path' => 'api/games-by-player/{id}',
            'defaults' => ['color' => 'brown'],
            'options' => ['my_option' => 'my_option_value'],
            'schemes' => ['https'],
            'host' => '{subdomain}.api-platform.com',
        ],
    ],
)]
#[AsController]
class GamesByUser extends AbstractController
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke($id): Response
    {
        $data = $this->userRepository->findGamesByUser($id);

        return new Response(json_encode($data));
    }
}
