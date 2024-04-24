<?php

namespace App\HttpClient;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiHttpClient extends AbstractController
{
    private $httpClient;
    // définit le constructeur qui prend un service HttpClientInterface en paramètre et l'injecte dans le champ $httpClient
    public function __construct(HttpClientInterface $jph)
    {
        // initialise le champ $httpClient avec l'instance du service HttpClient
        $this->httpClient = $jph;
    }

    // définit une méthode getUsers pour récupérer des utilisateurs depuis l'API
    public function getUsers()
    {
        // utilise le service HttpClient pour effectuer une requete GET à l'API avec un endpoint spécifié et des opitons, notamment la désactivation de la vérification SSL (verify_peer) et le nb de résultats à renvoyer
        $response = $this->httpClient->request('GET', "?results=15", [
            'verify_peer' => false,
        ]);
        // retourne les données de la réponse converties en tableau
        return $response->toArray();
    }
}