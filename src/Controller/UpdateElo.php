<?php

namespace App\Controller;


use App\Entity\ToPlay;
use App\Repository\CalculationEloRepository;
use App\Repository\GameRepository;
use App\Repository\ToPlayRepository;
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
                              ConvertEloLeagueOfLegends $convertEloLeagueOfLegends
    ): JsonResponse
    {
        $toPlay = $toPlayRepository->findOneBy(['user'=>$id]);
        $accountId = $toPlay->getAccountId();
        $datas = $apiLeagueOfLegends->apiLeaguesOfLegendsElo($accountId);
        $internalElo = 0;
        if(count($datas) > 0){
            $internalElo = $convertEloLeagueOfLegends->getInternalElo($datas[0]['tier'], $datas[0]['rank'], $datas[0]['leaguePoints']);

        }
        $toPlay->setElo($internalElo);
        $entityManager->persist($toPlay);
        $entityManager->flush();
        return new JsonResponse(
            'mise jour elo reussi'
        );
    }
}