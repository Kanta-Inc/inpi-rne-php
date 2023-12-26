<?php

namespace InpiRNEClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class InpiRNEClient implements InpiRNEClientInterface
{
    private $client;
    private $token;

    public function __construct($token = null)
    {
        $this->client = new Client(['base_uri' => 'https://registre-national-entreprises.inpi.fr/']);
        $this->token = $token;
    }

    public function authenticate($username, $password)
    {
        try {
            $this->token = null;
            $response = $this->client->post('api/sso/login', [
                'json' => [
                    'username' => $username,
                    'password' => $password
                ]
            ]);
            $data = json_decode($response->getBody(), true);
            $this->token = $data['token'];
        } catch (GuzzleException $e) {
            // Gestion des erreurs
        }
    }

    public function getToken()
    {
        return $this->token;
    }

    public function searchCompany($siren)
    {
        try {
            $response = $this->client->get("api/companies/{$siren}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token
                ]
            ]);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            // Gestion des erreurs
        }
    }

}