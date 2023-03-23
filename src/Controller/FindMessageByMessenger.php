<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class FindMessageByMessenger extends AbstractController
{

    private MessageRepository $messageRepository;
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function __invoke(int $idUserSend, int $idUserReceive): Response
    {
        $data = $this->messageRepository->findMessageByMessenger($idUserSend, $idUserReceive);

        return new Response(json_encode($data));
    }
}
