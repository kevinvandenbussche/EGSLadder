<?php

namespace App\Controller;

use App\Repository\ToPlayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use ApiPlatform\Core\Annotation\ApiResource;


#[ApiResource(
    collectionOperations: [
        'get' => [
            'path' => 'api/find-elo-by-user/{id}',
            'status' => 200,
        ],
    ],
    itemOperations: [
        'get' => [
            'path' => 'api/find-elo-by-user/{id}',
            'defaults' => ['color' => 'brown'],
            'options' => ['my_option' => 'my_option_value'],
            'schemes' => ['https'],
            'host' => '{subdomain}.api-platform.com',
        ],
    ],
)]
#[AsController]
class FindElo extends AbstractController
{
    private ToPlayRepository $toPlayRepository;
    public function __construct(ToPlayRepository $toPlayRepository)
    {
        $this->toPlayRepository = $toPlayRepository;

    }
    public function __invoke($id): Response
    {
        $data = $this->toPlayRepository->findAllEloByUser($id);
        return new Response(json_encode($data));
    }
}
