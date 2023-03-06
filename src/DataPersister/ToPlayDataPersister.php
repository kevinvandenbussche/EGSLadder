<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\ToPlay;
use App\Entity\User;
use App\Service\ApiLeagueOfLegends;
use function PHPUnit\Framework\throwException;

class ToPlayDataPersister implements ContextAwareDataPersisterInterface
{
    private ContextAwareDataPersisterInterface $decorated;

    public function __construct(ContextAwareDataPersisterInterface $decorated)
    {
        $this->decorated = $decorated;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof ToPlay;
    }

    public function persist($data, array $context = [])
    {
        $pseudonyme = $data->getPseudonyme();
        $client = new ApiLeagueOfLegends();
        $accountId = $client->getPlayerLeagueOfLegends($pseudonyme);
        if(!json_decode($accountId)){
            $data->setAccountId($accountId);
            return $this->decorated->persist($data, $context);
        }
        throwException(new \Exception());
        return null;

    }

    public function remove($data, array $context = [])
    {
        return $this->decorated->remove($data, $context);
    }

}
