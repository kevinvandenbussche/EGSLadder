<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use App\Service\MercureEndPoint;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class FindMessageByUser extends AbstractController
{
    private MessageRepository $messageRepository;

    public function __construct(MessageRepository $messageRepository, MercureEndPoint $mercure)
    {
        $this->messageRepository = $messageRepository;
    }

    public function __invoke($idUser): Response
    {
        $data = $this->messageRepository->findMessageByUser($idUser);
        return new Response(json_encode($data));
    }
}
