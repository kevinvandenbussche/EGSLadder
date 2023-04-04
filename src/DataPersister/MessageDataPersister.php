<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Message;
use App\Service\MercureEndPoint;
use function PHPUnit\Framework\throwException;

class MessageDataPersister implements ContextAwareDataPersisterInterface
{
    private ContextAwareDataPersisterInterface $decorated;
    private MercureEndPoint $mercure;

    public function __construct(ContextAwareDataPersisterInterface $decorated, MercureEndPoint $mercure)
    {
        $this->decorated = $decorated;
        $this->mercure = $mercure;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Message;
    }

    public function persist($data, array $context = [])
    {
        $mercure = $this->mercure ?? throw new \LogicException('MercureEndPoint not set in MessageDataPersister');
        dd($mercure->publishMessage($data));
        $mercure->publishMessage($data);
        return $this->decorated->persist($data, $context);
    }

    public function remove($data, array $context = [])
    {
        return $this->decorated->remove($data, $context);
    }

}
