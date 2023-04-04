<?php

namespace App\Service;

use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class MercureEndPoint
{
    private HubInterface $hub;

    public function __construct(HubInterface $hub)
    {
        $this->hub = $hub;
    }
    public function publishMessage($message)
    {
        // Créer un objet Update avec le contenu du message et l'URI du topic.
        $update = new Update(
            'http://example.com/my-topic',
            json_encode(['message' => $message])
        );

        // Publier le message sur le topic.
        $this->hub->publish($update);
    }

}

