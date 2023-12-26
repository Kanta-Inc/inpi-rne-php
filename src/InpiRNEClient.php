<?php

namespace InpiRNEClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class InpiRNEClient
 * 
 * @package InpiRNEClient
 */
class InpiRNEClient implements InpiRNEClientInterface
{
    private Client $client;
    private string $token;

    /**
     * InpiRNEClient constructor.
     * If a token is provided, it will be used for the requests
     * Otherwise, the user will have to authenticate first
     * 
     * @param string|null $token
     */
    public function __construct(?string $token = null)
    {
        $this->client = new Client(['base_uri' => 'https://registre-national-entreprises.inpi.fr/']);
        $this->token = $token;
    }

    /**
     * Authentify the user and store the token in the client
     * 
     * @param $username
     * @param $password
     * 
     * @throws GuzzleException
     * @return void
     */
    public function authenticate($username, $password): void
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
            // catch errors from the response
            // TODO: normalize the error message
            throw $e;
        }
    }

    /**
     * Get the token
     * 
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Search a company by its siren number
     * 
     * @param $siren
     * 
     * @throws GuzzleException
     * @return array
     */
    public function searchCompany($siren): array
    {
        try {
            $response = $this->client->get("api/companies/{$siren}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token
                ]
            ]);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            // catch errors from the response
            // TODO: normalize the error message
            throw $e;
        }
    }
}