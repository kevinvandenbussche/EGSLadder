<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use function PHPUnit\Framework\isEmpty;


//use ApiPlatform\Core\DataPersister\DataPersisterInterface;

final class UserDataPersister implements ContextAwareDataPersisterInterface
{
    private ContextAwareDataPersisterInterface $decorated;
    private $passwordHasheur;

    public function __construct(ContextAwareDataPersisterInterface $decorated, UserPasswordHasherInterface $passwordHasher)
    {
        $this->decorated = $decorated;
        $this->passwordHasheur = $passwordHasher;

    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    #[NoReturn] public function persist($data, array $context = [])
    {
        if($data->getPassword()){
            $data->setPassword(
                $this->passwordHasheur->hashPassword($data, $data->getPassword())
            );
            $data->eraseCredentials();
        }
        if ($data->getRoles()[0] !== "ROLE_USER" || isEmpty($data->getRoles()[0])) {
            $data->setRoles(["ROLE_USER"]);
            $data->eraseCredentials();
        }
        return $this->decorated->persist($data, $context);
    }

    public function remove($data, array $context = [])
    {
        return $this->decorated->remove($data, $context);
    }
}
