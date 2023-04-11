<?php

namespace InpiRne;

/**
 * Class InpiRne
 */
class InpiRneClient
{
    /** @var string The INPI RNE API token to be used for requests. */
    public static $apiToken;

    /** @var string The base URL for the INPI RNE API. */
    public static $apiBase = 'https://registre-national-entreprises.inpi.fr/api';
    public static $productionApiBase = 'https://registre-national-entreprises.inpi.fr/api';
    public static $testApiBase = 'https://registre-national-entreprises-pprod.inpi.fr/api';


    public static $testMode = false;

    /**
     * @return string the API token used for requests
     */
    public static function getApiToken()
    {
        return self::$apiToken;
    }

    /**
     * Sets the API key to be used for requests.
     *
     * @param string $apiToken
     */
    public static function setApiToken($apiToken)
    {
        self::$apiToken = $apiToken;
    }

    public static function enableTestMode()
    {
        self::$testMode = true;
        self::$apiBase = self::$testApiBase;
    }

    public static function disableTestMode()
    {
        self::$testMode = false;
        self::$apiBase = self::$productionApiBase;
    }

    public static function login($username, $password)
    {

        $payload = json_encode([
            "username" => $username,
            "password" => $password
        ]);

        $url = self::$apiBase . '/sso/login';

        $httpClient = new \GuzzleHttp\Client();

        $response = $httpClient->request('POST', $url, ['body' => $payload]);

        // if successful, set the token
        if ($response->getStatusCode() == 200) {
            $data = $response->getBody()->getContents();
            $data = json_decode($data);
            self::setApiToken($data->token);
            return $data->token;
        } else {
            return false;
        }
    }

    public static function getCompany(string $siren)
    {

        $url = self::$apiBase . '/companies/' . $siren;

        $httpClient = new \GuzzleHttp\Client();

        $response = $httpClient->request('GET', $url, [
            'headers' => [
                'Authorization' => "Bearer " . self::$apiToken
            ]
        ]);

        // if successful, set the token
        if ($response->getStatusCode() == 200) {
            $data = $response->getBody()->getContents();
            $data = json_decode($data);
            return $data;
        } else {
            return false;
        }
    }
}
