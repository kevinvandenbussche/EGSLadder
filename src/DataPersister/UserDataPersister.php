<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use Exception;
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

    /**
     * @throws Exception
     */
    #[NoReturn] public function persist($data, array $context = [])
    {
        if($data->getPassword()){
            $data->setPassword(
                $this->passwordHasheur->hashPassword($data, $data->getPassword())
            );
            $data->eraseCredentials();
        }
        if($data->getRoles()[0] == "ROLE_ADMIN"){
            $data->setRoles(['ROLE_ADMIN']);
        }else if(($data->getRoles()[0] == "ROLE_STAFF")){
            $data->setRoles(['ROLE_STAFF']);
        }else{
            $data->setRoles(['ROLE_USER']);
        }

        //je mets le nom et le prenom en minuscule
        $lowerName = strtolower($data->getName());
        $lowerFirstName = strtolower($data->getFirstName());

        //je verifie que le nom et le prenom ne contiennent pas le mot script suivi d'un espace
        if (preg_match('/^(?!.*script\s)/', $lowerName)) {
            $data->setName($lowerName);
        } else {
            throw new Exception("nom contient script");
        }

        if (preg_match('/^(?!.*script\s)/', $lowerFirstName)) {
            $data->setFirstName($lowerFirstName);
        } else {
            throw new Exception("prenom contient script");
        }

        //je verifie que le mail soit valide
        $email = $data->getEmail();
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $data->setEmail($email);
        } else {
            throw new Exception("Email is not valid");
        }

        return $this->decorated->persist($data, $context);
    }

    public function remove($data, array $context = [])
    {
        return $this->decorated->remove($data, $context);
    }
}
