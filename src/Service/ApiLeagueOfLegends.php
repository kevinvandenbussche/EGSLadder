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
                'https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-name/' . $pseudonyme . '?api_key=RGAPI-66bd56ff-13c1-47f6-bb14-16abcfd11c3f'
            );
            $arrayForAccountId = $responseForAccountId->toArray();
            $accountId = $arrayForAccountId["accountId"];
        } catch (\Exception $e) {
            var_dump("erreur lors de la recuperation du account id " . $e);
        }

        try {
            $responseForEncryptedId = $response->request(
                'GET',
                'https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-account/' . $accountId . '?api_key=RGAPI-66bd56ff-13c1-47f6-bb14-16abcfd11c3f'
            );
            $arrayForEncryptedId = $responseForEncryptedId->toArray();
            $encryptedId = $arrayForEncryptedId["id"];

            return $encryptedId;
        } catch (\Exception $e) {
            var_dump("erreur lors de la recuperation du encrypted id " . $e);
        }
        return null;
    }

    public function apiLeaguesOfLegendsElo($accountId):?array
    {
        $response = parent::getClient();
        $elo = 0;
        try {
            $responseForEncryptedId = $response->request(
                'GET',
                'https://euw1.api.riotgames.com/lol/league/v4/entries/by-summoner/' . $accountId . '?api_key=RGAPI-66bd56ff-13c1-47f6-bb14-16abcfd11c3f'
            );
            $arrayForElo = $responseForEncryptedId->toArray();

            return $arrayForElo;
        } catch (\Exception $e) {
            var_dump("erreur lors de la mise à jour de l'elo " . $e);
        }
        return null;
    }

}