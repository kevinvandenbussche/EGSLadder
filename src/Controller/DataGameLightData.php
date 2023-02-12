<?php

namespace App\Controller;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Response;


#[ApiResource(
    collectionOperations: [
        'get' => [
            'path' => '/api/data-game',
            'status' => 200,
        ],
    ],
    itemOperations: [
        'get' => [
            'path' => '/api/data-game',
            'defaults' => ['color' => 'brown'],
            'options' => ['my_option' => 'my_option_value'],
            'schemes' => ['https'],
            'host' => '{subdomain}.api-platform.com',
        ],
    ],
)]
#[AsController]
class DataGameLightData extends AbstractController
{
    private GameRepository $gameRepository;
    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }
    public function __invoke(): Response
    {
        $data = $this->gameRepository->findGame();

        return new Response(json_encode($data));
    }

}
