<?php

namespace App\Tests\Controller;

use App\Repository\ToPlayRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UpdateEloTest extends WebTestCase
{
    private static $container;

    public function testUpdateElo(): void
    {
        $client = static::createClient();

        // Récupération d'un utilisateur existant
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneBy([]);

        // Récupération d'un ToPlay existant pour l'utilisateur
        $toPlayRepository = static::$container->get(ToPlayRepository::class);
        $toPlay = $toPlayRepository->findOneBy(['user' => $user->getId()]);

        $url = '/api/update-elo/' . $user->getId();

        // Appel de l'URL pour mettre à jour l'elo
        $client->request('GET', $url);

        // Vérification que la réponse est bien 201
        $this->assertSame(201, $client->getResponse()->getStatusCode());

        // Vérification que la nouvelle entité ToPlay a bien été créée avec l'elo mis à jour
        $newToPlay = $toPlayRepository->findOneBy(['user' => $user->getId()]);
        $this->assertNotNull($newToPlay);
        $this->assertGreaterThan($toPlay->getElo(), $newToPlay->getElo());
    }
}

