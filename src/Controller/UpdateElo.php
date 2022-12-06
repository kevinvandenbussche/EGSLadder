<?php

namespace App\Controller;


use App\Entity\ToPlay;
use App\Repository\CalculationEloRepository;
use App\Repository\GameRepository;
use App\Repository\ToPlayRepository;
use App\Repository\UserRepository;
use App\Service\ApiLeagueOfLegends;
use App\Service\ConvertEloLeagueOfLegends;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class UpdateElo extends AbstractController
{
    #[Route('api/update-elo/{id}', name: 'update_elo', methods: "POST")]

    public function updateElo(ToPlayRepository $toPlayRepository,
                              $id,
                              ApiLeagueOfLegends $apiLeagueOfLegends,
                              EntityManagerInterface $entityManager,
                              ConvertEloLeagueOfLegends $convertEloLeagueOfLegends,
                              UserRepository $userRepository
    ): JsonResponse
    {
        //je recupere les données utilisateurs de ma table Toplay
        $toPlayOld = $toPlayRepository->findOneBy(['user'=>$id]);
        $accountId = $toPlayOld->getAccountId();
        $startdate = $toPlayOld->getDateStart();
        $startEnd = $toPlayOld->getDateEnd();
        $game = $toPlayOld->getGame();
        $datas = $apiLeagueOfLegends->apiLeaguesOfLegendsElo($accountId);
        $user = $userRepository->find($id);
        $internalElo = 0;
        if(count($datas) > 0){
            $internalElo = $convertEloLeagueOfLegends->getInternalElo($datas[0]['tier'], $datas[0]['rank'], $datas[0]['leaguePoints']);
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
        $entityManager->persist($newToplay);
        $entityManager->flush();
        return new JsonResponse(
            'mise jour elo reussi'
        );
    }
}