<?php

namespace InpiRne;

/**
 * Class InpiRne
 */
class MockInpiRneClient
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
        $successResponse = true;

        // if successful, set the token
        if ($successResponse) {
            $data = TestTools::MOCK_INPI_LOGIN_PAYLOAD;
            self::setApiToken($data['token']);
            return $data['token'];
        } else {
            return false;
        }
    }

    public static function getCompany(string $siren)
    {
        $successResponse = true;


        // if successful, set the token
        if ($successResponse) {
            $data = TestTools::MOCK_INPI_COMPANY_LEGAL_ENTITY_PAYLOAD;
            return $data;
        } else {
            return false;
        }
    }
}
