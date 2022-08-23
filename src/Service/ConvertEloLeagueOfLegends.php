<?php

namespace App\Service;

use App\Repository\CalculationEloRepository;
use App\Repository\GameRepository;

class ConvertEloLeagueOfLegends
{
    private CalculationEloRepository $calculationEloRepository;
    private GameRepository $gameRepository;
    //variable de class equivalent à private
    const gameName = 'league of legends';

    public function __construct(CalculationEloRepository $calculationEloRepository, GameRepository $gameRepository)
    {
        $this->calculationEloRepository = $calculationEloRepository;
        $this->gameRepository = $gameRepository;
    }

    public function getInternalELo(string $tier, string $rank, int $leaguePoints): ?int
    {
        $romans = [
            'IV' => 4,
            'I' => 1
        ];
        $result = 0;
        //convertion des chiffres romains en chiffres arabes
        foreach ($romans as $key => $value){
            while (str_starts_with($rank, $key)) {
                $result += $value;
                $rank = substr($rank, strlen($key));
            }
        }
        //met en lower case le rank du joueur
        $lowerCaseTier = strtolower($tier);
        $rankConvert = $lowerCaseTier . ' ' . $result;
        //recupere les elos interne selon l'id du jeu dans la table calculation_elo
        $game = $this->gameRepository->findOneBy(['name' => self::gameName]);
        $arrayEloInteral = $this->calculationEloRepository->findBy(['game' => $game]);
        $eloPlayer = 0;
        foreach ($arrayEloInteral as $eloInternal){
            //compare les divsions_game en interne à celle du joueur
            if($eloInternal->getDivisionGame() == $rankConvert){
                //addition les point du jeu à celle de la table calculation _elo
                $eloPlayer = $eloInternal->getEloInternal() + $leaguePoints;
            }
        }
        return $eloPlayer;
    }
}