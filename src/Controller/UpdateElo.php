<?php

namespace App\Controller;


use App\Entity\ToPlay;
use App\Repository\ToPlayRepository;
use App\Repository\UserRepository;
use App\Service\ApiLeagueOfLegends;
use App\Service\ConvertEloLeagueOfLegends;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[ApiResource(
    collectionOperations: [
        'get' => [
            'path' => 'api/update-elo/{id}',
            'status' => 201,
        ],
    ],
)]
#[AsController]
class UpdateElo extends AbstractController
{
    private UserRepository $userRepository;
    private ToPlayRepository $toPlayRepository;
    private EntityManagerInterface $entityManager;
    private ApiLeagueOfLegends $apiLeagueOfLegends;
    private ConvertEloLeagueOfLegends $convertEloLeagueOfLegends;

    public function __construct(UserRepository $userRepository,
                                ToPlayRepository $toPlayRepository,
                                EntityManagerInterface $entityManager,
                                ApiLeagueOfLegends $apiLeagueOfLegends,
                                ConvertEloLeagueOfLegends $convertEloLeagueOfLegends)
    {
        $this->userRepository = $userRepository;
        $this->toPlayRepository = $toPlayRepository;
        $this->entityManager = $entityManager;
        $this->apiLeagueOfLegends = $apiLeagueOfLegends;
        $this->convertEloLeagueOfLegends = $convertEloLeagueOfLegends;
    }


    public function __invoke($id): Response
    {
        //je recupere les données utilisateurs de ma table Toplay
        $toPlayOld = $this->toPlayRepository->findOneBy(['user'=>$id]);
        $accountId = $toPlayOld->getAccountId();
        $startdate = $toPlayOld->getDateStart();
        $startEnd = $toPlayOld->getDateEnd();
        $game = $toPlayOld->getGame();
        $datas = $this->apiLeagueOfLegends->apiLeaguesOfLegendsElo($accountId);
        $user = $this->userRepository->find($id);
        $internalElo = 0;
        if(count($datas) > 0){
            $internalElo = $this->convertEloLeagueOfLegends->getInternalElo($datas[0]['tier'], $datas[0]['rank'], $datas[0]['leaguePoints']);
        }
        //je créer une nouvelle entité avec les données de l'utilisateur et je mets les nouvelles données recuperé de l'api
        $newToplay = new Toplay();
        $newToplay->setPseudonyme($datas[0]['summonerName']);
        $newToplay->setDateRegisterElo(new \DateTime());
        $newToplay->setElo($internalElo);
        $newToplay->setUser($user);
        $newToplay->setDateStart($startdate);
        if($startEnd != null){
            $newToplay->setDateEnd($startEnd);
        }
        $newToplay->setAccountId($accountId);
        $newToplay->setGame($game);
        $this->entityManager->persist($newToplay);
        $this->entityManager->flush();

        return new JsonResponse(
            'mise jour elo reussi'
        );
    }
}
