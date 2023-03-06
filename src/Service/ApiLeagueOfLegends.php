<?php
namespace App\Service;

class ApiLeagueOfLegends extends HttpClient
{

    public function getPlayerLeagueOfLegends(?string $pseudonyme): ?string
    {
        //on herite de http client et on utilise le mot cles parent pour utiliser httpClient et les methodes associés
        $response = parent::getClient();
        $accountId = "";

        try {
            $responseForAccountId = $response->request(
                'GET',
                'https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-name/' . $pseudonyme . '?api_key=RGAPI-df1be0e0-0829-4a37-ba74-77065b87f501'
            );
            $arrayForAccountId = $responseForAccountId->toArray();
            $accountId = $arrayForAccountId["accountId"];
        } catch (\Exception $e) {
            var_dump("erreur lors de la recuperation du account id " . $e);
        }

        try {
            $responseForEncryptedId = $response->request(
                'GET',
                'https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-account/' . $accountId . '?api_key=RGAPI-df1be0e0-0829-4a37-ba74-77065b87f501'
            );
            $arrayForEncryptedId = $responseForEncryptedId->toArray();
            return $arrayForEncryptedId["id"];
        } catch (\Exception $e) {
            var_dump("erreur lors de la recuperation du encrypted id " . $e);
        }
        return null;
    }

    public function apiLeaguesOfLegendsElo($accountId):?array
    {
        $response = parent::getClient();
        try {
            $responseForEncryptedId = $response->request(
                'GET',
                'https://euw1.api.riotgames.com/lol/league/v4/entries/by-summoner/' . $accountId . '?api_key=RGAPI-df1be0e0-0829-4a37-ba74-77065b87f501'
            );
            $arrayForElo = $responseForEncryptedId->toArray();

            return $arrayForElo;
        } catch (\Exception $e) {
            var_dump("erreur lors de la mise à jour de l'elo " . $e);
        }
        return null;
    }

}
