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
                'https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-name/' . $pseudonyme . '?api_key=RGAPI-992366c5-bc2f-45a4-86d3-6b429e562de6'
            );
            $arrayForAccountId = $responseForAccountId->toArray();
            $accountId = $arrayForAccountId["accountId"];
        } catch (\Exception $e) {
            var_dump("erreur lors de la recuperation du account id " . $e);
        }

        try {
            $responseForEncryptedId = $response->request(
                'GET',
                'https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-account/' . $accountId . '?api_key=RGAPI-992366c5-bc2f-45a4-86d3-6b429e562de6'
            );
            $arrayForEncryptedId = $responseForEncryptedId->toArray();
            $encryptedId = $arrayForEncryptedId["id"];
            return $encryptedId;
        } catch (\Exception $e) {
            var_dump("erreur lors de la recuperation du encrypted id " . $e);
        }
        return null;
    }

}