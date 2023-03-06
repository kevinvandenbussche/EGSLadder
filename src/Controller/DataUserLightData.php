<?php

namespace App\Controller;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'path' => 'api/data-user-for-main-page',
            'status' => 200,
        ],

    ],
    itemOperations: [
        'get' => [
            'path' => 'api/data-user-for-main-page',
            'defaults' => ['color' => 'brown'],
            'options' => ['my_option' => 'my_option_value'],
            'schemes' => ['https'],
            'host' => '{subdomain}.api-platform.com',
        ],
    ],
)]
class DataUserLightData extends AbstractController
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(): Response
    {
        $data = $this->userRepository->findUserLight();

        return new Response(json_encode($data));
    }

}



